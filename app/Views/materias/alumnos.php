<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><i class="bi bi-people"></i> Alumnos por Materia</h1>
            <p class="mb-0 text-muted"><?php echo esc($materia['nombre_materia']);?></p>
        </div>
        <a href="<?php echo base_url('materias');?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver a materias
        </a>
    </div>

    <?php if (!empty($alumnos)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Carnet</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnos as $alumno): ?>
                        <?php
                            $fotoPath = !empty($alumno['foto'])
                                ? base_url('uploads/' . $alumno['foto'])
                                : null;
                        ?>
                        <tr>
                            <td>
                                <?php if ($fotoPath !== null): ?>
                                    <img src="<?php echo esc($fotoPath);?>" alt="Foto" width="48" height="48" class="rounded-circle border">
                                <?php else: ?>
                                    <span class="badge bg-secondary">Sin foto</span>
                                <?php endif;?>
                            </td>
                            <td><?php echo esc($alumno['codigo']);?></td>
                            <td><?php echo esc($alumno['nombre'] . ' ' . $alumno['apellido']);?></td>
                            <td><?php echo esc($alumno['email']);?></td>
                            <td><?php echo esc($alumno['telefono'] ?? '-');?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No hay alumnos inscritos en esta materia.
        </div>
    <?php endif;?>
</div>

<?php echo $this->endSection();?>

