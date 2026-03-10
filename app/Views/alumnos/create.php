<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus"></i> Crear Nuevo Alumno
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

                    <form action="<?php echo base_url('alumnos/store');?>" method="POST" id="formAlumno">
                        <?php echo csrf_field();?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo (session('validation') && session('validation')->hasError('nombre')) ? 'is-invalid' : '';?>" 
                                       id="nombre" name="nombre" required minlength="2" maxlength="100"
                                       value="<?php echo old('nombre', '');?>">
                                <?php if (session('validation') && session('validation')->hasError('nombre')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo session('validation')->getError('nombre');?>
                                    </div>
                                <?php endif;?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo (session('validation') && session('validation')->hasError('apellido')) ? 'is-invalid' : '';?>" 
                                       id="apellido" name="apellido" required minlength="2" maxlength="100"
                                       value="<?php echo old('apellido', '');?>">
                                <?php if (session('validation') && session('validation')->hasError('apellido')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo session('validation')->getError('apellido');?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control <?php echo (session('validation') && session('validation')->hasError('email')) ? 'is-invalid' : '';?>" 
                                   id="email" name="email" required maxlength="100"
                                   value="<?php echo old('email', '');?>">
                            <?php if (session('validation') && session('validation')->hasError('email')): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo session('validation')->getError('email');?>
                                </div>
                            <?php endif;?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control <?php echo (session('validation') && session('validation')->hasError('telefono')) ? 'is-invalid' : '';?>" 
                                       id="telefono" name="telefono" pattern="[0-9]{8}"
                                       value="<?php echo old('telefono', '');?>">
                                <small class="text-muted">Formato: 8 dígitos</small>
                                <?php if (session('validation') && session('validation')->hasError('telefono')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo session('validation')->getError('telefono');?>
                                    </div>
                                <?php endif;?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="codigo" class="form-label">Código de Estudiante <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php echo (session('validation') && session('validation')->hasError('codigo')) ? 'is-invalid' : '';?>" 
                                       id="codigo" name="codigo" required maxlength="20"
                                       value="<?php echo old('codigo', '');?>">
                                <?php if (session('validation') && session('validation')->hasError('codigo')): ?>
                                    <div class="invalid-feedback d-block">
                                        <?php echo session('validation')->getError('codigo');?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="codigo_carrera" class="form-label">Carrera <span class="text-danger">*</span></label>
                            <select class="form-select <?php echo (session('validation') && session('validation')->hasError('codigo_carrera')) ? 'is-invalid' : '';?>" 
                                    id="codigo_carrera" name="codigo_carrera" required>
                                <option value="">Seleccionar carrera...</option>
                                <?php if (!empty($carreras)): ?>
                                    <?php foreach ($carreras as $carrera): ?>
                                        <option value="<?php echo $carrera['codigo_carrera'];?>" 
                                                <?php echo old('codigo_carrera') == $carrera['codigo_carrera'] ? 'selected' : '';?>>
                                            <?php echo esc($carrera['nombre_carrera']);?>
                                        </option>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </select>
                            <?php if (session('validation') && session('validation')->hasError('codigo_carrera')): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo session('validation')->getError('codigo_carrera');?>
                                </div>
                            <?php endif;?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Guardar
                            </button>
                            <a href="<?php echo base_url('alumnos');?>" class="btn btn-secondary">
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
