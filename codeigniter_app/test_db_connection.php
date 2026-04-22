<?php
$host = 'aws-0-us-west-2.pooler.supabase.com';
$port = 6543;
$dbname = 'postgres';
$user = 'postgres.zeukpybmnurnckiophdo';
$password = 'vfNQu!9TZy3!PHe';

echo "Intentando conectar a PostgreSQL...\n";
echo "Host: $host\n";
echo "Puerto: $port\n";
echo "Usuario: $user\n";
echo "Base de datos: $dbname\n\n";

try {
    // Usando PDO
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);
    
    echo "✓ Conexión exitosa con PDO!\n\n";
    
    // Verificar versión de PostgreSQL
    $result = $pdo->query('SELECT version()');
    $version = $result->fetchColumn();
    echo "Versión PostgreSQL: $version\n";
    
    // Listar tablas
    $result = $pdo->query("
        SELECT table_name FROM information_schema.tables 
        WHERE table_schema = 'public'
    ");
    $tables = $result->fetchAll(PDO::FETCH_COLUMN);
    
    echo "\nTablas en la base de datos:\n";
    if (!empty($tables)) {
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    } else {
        echo "  (No hay tablas)\n";
    }
    
} catch (PDOException $e) {
    echo "✗ Error de conexión: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
