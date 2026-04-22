<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-person"></i> Detalles del Alumno
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <?php if (!empty($alumno['foto'])): ?>
                            <img src="<?php echo base_url('uploads/' . $alumno['foto']);?>" alt="Foto del alumno" width="120" height="120" class="rounded-circle border">
                        <?php else: ?>
                            <span class="badge bg-secondary fs-6">Sin foto</span>
                        <?php endif;?>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">
                                <i class="bi bi-person-badge"></i> Nombre
                            </h6>
                            <p class="h5"><?php echo esc($alumno['nombre']);?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">
                                <i class="bi bi-person-badge"></i> Apellido
                            </h6>
                            <p class="h5"><?php echo esc($alumno['apellido']);?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">
                                <i class="bi bi-envelope"></i> Email
                            </h6>
                            <p><a href="mailto:<?php echo esc($alumno['email']);?>"><?php echo esc($alumno['email']);?></a></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">
                                <i class="bi bi-telephone"></i> Teléfono
                            </h6>
                            <p><?php echo !empty($alumno['telefono']) ? esc($alumno['telefono']) : '<em class="text-muted">No registrado</em>';?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">
                                <i class="bi bi-hash"></i> Carnet
                            </h6>
                            <p><strong><?php echo esc($alumno['codigo']);?></strong></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">
                                <i class="bi bi-mortarboard"></i> Carrera
                            </h6>
                            <p>
                                <?php if (!empty($carrera)): ?>
                                    <?php echo esc($carrera['nombre_carrera']);?>
                                <?php else: ?>
                                    <em class="text-muted">No asignada</em>
                                <?php endif;?>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?php echo base_url('alumnos/edit/' . $alumno['id']);?>" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="<?php echo base_url('alumnos/delete/' . $alumno['id']);?>" class="btn btn-danger" 
                           onclick="return confirm('¿Estás seguro de que deseas eliminar este alumno?');">
                            <i class="bi bi-trash"></i> Eliminar
                        </a>
                        <a href="<?php echo base_url('alumnos');?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>
