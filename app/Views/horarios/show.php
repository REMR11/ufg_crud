<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-info-circle"></i> Detalles del Horario de Docente
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted"><i class="bi bi-person"></i> Docente</h6>
                            <p class="fs-5 fw-bold"><?php echo esc($horario['nombre_docente']);?></p>
                            <small class="text-muted">
                                <i class="bi bi-envelope"></i> <?php echo esc($horario['email_docente']);?><br>
                                <i class="bi bi-telephone"></i> <?php echo esc($horario['telefono_docente']);?>
                            </small>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted"><i class="bi bi-book"></i> Materia</h6>
                            <p class="fs-5 fw-bold"><?php echo esc($horario['nombre_materia']);?></p>
                            <small class="text-muted">
                                <span class="badge bg-success">Materias inscritas: <?php echo esc($total_materias);?>/5</span>
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h6 class="text-muted"><i class="bi bi-calendar2-week"></i> Día</h6>
                            <p class="fs-5 fw-bold text-uppercase"><?php echo esc($horario['dia']);?></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted"><i class="bi bi-clock-history"></i> Hora Inicio</h6>
                            <p class="fs-5 fw-bold"><?php echo esc($horario['hora_inicio']);?></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted"><i class="bi bi-clock"></i> Hora Fin</h6>
                            <p class="fs-5 fw-bold"><?php echo esc($horario['hora_fin']);?></p>
                        </div>
                    </div>

                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Duración:</strong> 2 horas (de <?php echo esc($horario['hora_inicio']);?> a <?php echo esc($horario['hora_fin']);?>)
                    </div>

                    <!-- Mostrar aviso si el docente está cerca del límite -->
                    <?php if ($total_materias >= 4): ?>
                        <div class="alert alert-warning mb-4">
                            <i class="bi bi-exclamation-triangle"></i> 
                            <strong>Atención:</strong> Este docente está cerca del límite de materias (<?php echo esc($total_materias);?>/5)
                        </div>
                    <?php endif;?>

                    <div class="d-flex gap-2">
                        <a href="<?php echo base_url('horarios/edit/' . $horario['id']);?>" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="<?php echo base_url('horarios/delete/' . $horario['id']);?>" 
                           class="btn btn-danger"
                           onclick="return confirm('¿Estás seguro de que deseas eliminar este horario?');">
                            <i class="bi bi-trash"></i> Eliminar
                        </a>
                        <a href="<?php echo base_url('horarios');?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>
