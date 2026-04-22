<?php echo $this->extend('layouts/main'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card principal con detalles del alumno y carrera -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h3 class="mb-0"><i class="bi bi-eye"></i> Detalle de Asignación</h3>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Información del Alumno</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th style="width: 40%;">Nombre:</th>
                                    <td><strong><?php echo esc($asignacion['nombre'] . ' ' . $asignacion['apellido']); ?></strong></td>
                                </tr>
                                <tr>
                                    <th>Código:</th>
                                    <td><code><?php echo esc($asignacion['codigo']); ?></code></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><a href="mailto:<?php echo esc($asignacion['email']); ?>"><?php echo esc($asignacion['email']); ?></a></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-muted">Información de la Carrera</h5>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th style="width: 40%;">Carrera:</th>
                                    <td><strong><?php echo esc($asignacion['nombre_carrera']); ?></strong></td>
                                </tr>
                                <tr>
                                    <th>Código:</th>
                                    <td><code><?php echo esc($asignacion['codigo_carrera']); ?></code></td>
                                </tr>
                                <tr>
                                    <th>ID Asignación:</th>
                                    <td><span class="badge bg-secondary"><?php echo $asignacion['id']; ?></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="<?php echo base_url('alumno_carrera/edit/' . $asignacion['id']); ?>" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="<?php echo base_url('alumno_carrera/delete/' . $asignacion['id']); ?>" 
                           class="btn btn-danger"
                           onclick="return confirm('¿Está seguro de eliminar esta asignación?');">
                            <i class="bi bi-trash"></i> Eliminar
                        </a>
                        <a href="<?php echo base_url('alumno_carrera'); ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver al Listado
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card con otras carreras del mismo alumno -->
            <?php if (!empty($otrasCarreras) && count($otrasCarreras) > 1): ?>
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-list"></i> Otras Carreras del Alumno</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Carrera</th>
                                        <th>Código</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($otrasCarreras as $carrera): ?>
                                        <?php if ($carrera['id_carrera'] != $asignacion['id_carrera']): ?>
                                            <tr>
                                                <td><?php echo esc($carrera['nombre_carrera']); ?></td>
                                                <td><code><?php echo esc($carrera['codigo_carrera']); ?></code></td>
                                                <td>
                                                    <a href="<?php echo base_url('alumno_carrera/show/' . $carrera['id']); ?>" 
                                                       class="btn btn-sm btn-info">
                                                        <i class="bi bi-eye"></i> Ver
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Este alumno solo tiene asignada esta carrera.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
