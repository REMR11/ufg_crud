<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreateMigrationCommand extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'make:migrations';
    protected $description = 'Detecta cambios en modelos y genera migraciones automáticamente (como EF Core)';
    protected $usage       = 'make:migrations';

    private $snapshotFile;
    private $modelsPath;

    public function run(array $params = [])
    {
        $this->snapshotFile = APPPATH . '.model-snapshot.json';
        $this->modelsPath = APPPATH . 'Models/';

        CLI::write('🔍 Analizando modelos...', 'cyan');

        $currentModels = $this->getModelsStructure();
        $previousModels = $this->getPreviousSnapshot();
        $changes = $this->detectChanges($previousModels, $currentModels);

        if (empty($changes['new_tables']) && empty($changes['modified_tables']) && empty($changes['deleted_tables'])) {
            CLI::write('✅ No hay cambios detectados', 'green');
            return;
        }

        $this->displayChanges($changes);
        $this->generateMigrations($changes);
        $this->saveSnapshot($currentModels);

        CLI::write("\n✅ Migraciones generadas correctamente", 'green');
        CLI::write('Ejecuta: php spark migrate', 'yellow');
    }

    private function getModelsStructure()
    {
        $models = [];
        $files = scandir($this->modelsPath);

        foreach ($files as $file) {
            if (strpos($file, '.php') === false || $file === '..' || $file === '.') continue;

            $className = str_replace('.php', '', $file);
            $modelClass = "App\\Models\\{$className}";

            if (!class_exists($modelClass)) continue;

            try {
                $model = new $modelClass();
                $tableName = $model->getTable();
                $allowedFields = $model->getAllowedFields();

                if (!empty($allowedFields)) {
                    $models[$tableName] = [
                        'model' => $className,
                        'fields' => $allowedFields,
                    ];
                }
            } catch (\Exception $e) {
                CLI::write("⚠️  Error en {$className}", 'yellow');
            }
        }

        return $models;
    }

    private function getPreviousSnapshot()
    {
        if (!file_exists($this->snapshotFile)) return [];
        return json_decode(file_get_contents($this->snapshotFile), true) ?? [];
    }

    private function detectChanges($previous, $current)
    {
        $changes = [
            'new_tables' => [],
            'deleted_tables' => [],
            'modified_tables' => [],
        ];

        foreach ($current as $tableName => $structure) {
            if (!isset($previous[$tableName])) {
                $changes['new_tables'][$tableName] = $structure;
            }
        }

        foreach ($previous as $tableName => $structure) {
            if (!isset($current[$tableName])) {
                $changes['deleted_tables'][$tableName] = $structure;
            }
        }

        foreach ($current as $tableName => $structure) {
            if (isset($previous[$tableName])) {
                $prevFields = $previous[$tableName]['fields'];
                $currFields = $structure['fields'];
                $newFields = array_diff($currFields, $prevFields);
                $deletedFields = array_diff($prevFields, $currFields);

                if (!empty($newFields) || !empty($deletedFields)) {
                    $changes['modified_tables'][$tableName] = [
                        'new_fields' => array_values($newFields),
                        'deleted_fields' => array_values($deletedFields),
                    ];
                }
            }
        }

        return $changes;
    }

    private function displayChanges($changes)
    {
        if (!empty($changes['new_tables'])) {
            CLI::write("\n📌 Nuevas Tablas:", 'yellow');
            foreach ($changes['new_tables'] as $tableName => $structure) {
                CLI::write("  • {$tableName} ({$structure['model']})", 'white');
            }
        }

        if (!empty($changes['modified_tables'])) {
            CLI::write("\n📝 Tablas Modificadas:", 'yellow');
            foreach ($changes['modified_tables'] as $tableName => $change) {
                CLI::write("  • {$tableName}", 'white');
                foreach ($change['new_fields'] as $f) CLI::write("    ➕ +{$f}", 'green');
                foreach ($change['deleted_fields'] as $f) CLI::write("    ➖ -{$f}", 'red');
            }
        }
    }

    private function generateMigrations($changes)
    {
        $baseTimestamp = date('Y_m_d_His');
        $count = 0;

        foreach ($changes['new_tables'] as $tableName => $structure) {
            $this->createNewTableMigration($tableName, $structure['fields'], $baseTimestamp . str_pad($count++, 2, '0', STR_PAD_LEFT));
        }

        foreach ($changes['modified_tables'] as $tableName => $change) {
            $this->createAlterTableMigration($tableName, $change, $baseTimestamp . str_pad($count++, 2, '0', STR_PAD_LEFT));
        }
    }

    private function createNewTableMigration($tableName, $fields, $timestamp)
    {
        $className = 'Create' . ucfirst($tableName) . 'Table';
        $filename = APPPATH . "Database/Migrations/{$timestamp}_" . $className . '.php';

        $fieldCode = "        \$this->forge->addField([\n";
        $fieldCode .= "            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],\n";
        foreach ($fields as $field) {
            $fieldCode .= "            '{$field}' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],\n";
        }
        $fieldCode .= "            'created_at' => ['type' => 'DATETIME', 'null' => true],\n";
        $fieldCode .= "            'updated_at' => ['type' => 'DATETIME', 'null' => true],\n";
        $fieldCode .= "        ]);\n";

        $content = "<?php\n\nnamespace App\Database\Migrations;\n\nuse CodeIgniter\Database\Migration;\n\nclass {$className} extends Migration\n{\n    public function up()\n    {\n{$fieldCode}        \$this->forge->addKey('id', false, true);\n        \$this->forge->createTable('{$tableName}');\n    }\n\n    public function down()\n    {\n        \$this->forge->dropTable('{$tableName}');\n    }\n}\n";

        write_file($filename, $content);
    }

    private function createAlterTableMigration($tableName, $change, $timestamp)
    {
        $className = 'Modify' . ucfirst($tableName) . 'Table';
        $filename = APPPATH . "Database/Migrations/{$timestamp}_" . $className . '.php';

        $upCode = "";
        $downCode = "";

        foreach ($change['new_fields'] as $field) {
            $upCode .= "        \$this->forge->addColumn('{$tableName}', ['{$field}' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true]]);\n";
            $downCode .= "        \$this->forge->dropColumn('{$tableName}', '{$field}');\n";
        }

        foreach ($change['deleted_fields'] as $field) {
            $upCode .= "        \$this->forge->dropColumn('{$tableName}', '{$field}');\n";
            $downCode .= "        \$this->forge->addColumn('{$tableName}', ['{$field}' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true]]);\n";
        }

        $content = "<?php\n\nnamespace App\Database\Migrations;\n\nuse CodeIgniter\Database\Migration;\n\nclass {$className} extends Migration\n{\n    public function up()\n    {\n{$upCode}    }\n\n    public function down()\n    {\n{$downCode}    }\n}\n";

        write_file($filename, $content);
    }

    private function saveSnapshot($models)
    {
        file_put_contents($this->snapshotFile, json_encode($models, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}