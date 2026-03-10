<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Editar Carrera
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Mostrar errores de validación -->
                    <?php if (session()->has('validation')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5><i class="bi bi-exclamation-triangle"></i> Error en la validación:</h5>
                            <ul class="mb-0">
                                <?php foreach (session('validation')->getErrors() as $error): ?>
                                    <li><?php echo $error;?></li>
                                <?php endforeach;?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif;?>

                    <form action="<?php echo base_url('carreras/update/' . $carrera['id']);?>" method="POST" id="formCarrera">
                        <?php echo csrf_field();?>

                        <div class="mb-3">
                            <label for="codigo_carrera" class="form-label">Código de Carrera</label>
                            <input type="text" class="form-control" id="codigo_carrera" 
                                   value="<?php echo esc($carrera['codigo_carrera'] ?? '');?>" disabled>
                            <small class="text-muted">El código no puede ser modificado</small>
                        </div>

                        <div class="mb-3">
                            <label for="nombre_carrera" class="form-label">Nombre de la Carrera <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php echo (session('validation') && session('validation')->hasError('nombre_carrera')) ? 'is-invalid' : '';?>" 
                                   id="nombre_carrera" name="nombre_carrera" required minlength="2" maxlength="150"
                                   value="<?php echo esc($carrera['nombre_carrera']);?>">
                            <?php if (session('validation') && session('validation')->hasError('nombre_carrera')): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo session('validation')->getError('nombre_carrera');?>
                                </div>
                            <?php endif;?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Actualizar
                            </button>
                            <a href="<?php echo base_url('carreras');?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>
