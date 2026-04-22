<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-mortarboard"></i> Detalles de la Carrera
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">
                            <i class="bi bi-hash"></i> Código de Carrera
                        </h6>
                        <p class="h5"><?php echo esc($carrera['codigo_carrera']);?></p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">
                            <i class="bi bi-book"></i> Nombre de Carrera
                        </h6>
                        <p class="h5"><?php echo esc($carrera['nombre_carrera']);?></p>
                    </div>

                    <hr>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?php echo base_url('carreras/edit/' . $carrera['id']);?>" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="<?php echo base_url('carreras/delete/' . $carrera['id']);?>" class="btn btn-danger" 
                           onclick="return confirm('¿Estás seguro de que deseas eliminar esta carrera?');">
                            <i class="bi bi-trash"></i> Eliminar
                        </a>
                        <a href="<?php echo base_url('carreras');?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>
