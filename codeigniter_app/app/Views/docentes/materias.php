<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><i class="bi bi-journal-bookmark"></i> Materias por Docente</h1>
            <p class="mb-0 text-muted">
                <?php echo esc($docente['nombre'] . ' ' . $docente['apellido']);?>
            </p>
        </div>
        <a href="<?php echo base_url('docentes');?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver a docentes
        </a>
    </div>

    <?php if (!empty($horarios)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Materia</th>
                        <th>Día</th>
                        <th>Bloque</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horarios as $horario): ?>
                        <tr>
                            <td><?php echo esc($horario['nombre_materia']);?></td>
                            <td><?php echo esc(ucfirst($horario['dia']));?></td>
                            <td><?php echo esc($horario['bloque'] ?? '-');?></td>
                            <td><?php echo esc($horario['hora_inicio']);?></td>
                            <td><?php echo esc($horario['hora_fin']);?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Este docente no tiene materias inscritas.
        </div>
    <?php endif;?>
</div>

<?php echo $this->endSection();?>

