<?php echo $this->extend('layouts/main'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-plus-circle"></i> Nueva Asignación Alumno-Carrera</h3>
                </div>

                <div class="card-body">
                    <!-- Mostrar errores de validación -->
                    <?php if (session()->getFlashdata('validation')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> <strong>Errores de validación:</strong>
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('validation')->getErrors() as $field => $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?php echo base_url('alumno_carrera/store'); ?>" id="alumnoCarreraForm" novalidate>
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="id_alumno" class="form-label"><i class="bi bi-person"></i> Alumno *</label>
                            <select class="form-select <?php echo session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('id_alumno') ? 'is-invalid' : ''; ?>" 
                                    id="id_alumno" name="id_alumno" required>
                                <option value="">-- Seleccionar alumno --</option>
                                <?php foreach ($alumnos as $alumno): ?>
                                    <option value="<?php echo $alumno['id']; ?>" 
                                            <?php echo old('id_alumno') == $alumno['id'] ? 'selected' : ''; ?>>
                                        <?php echo esc($alumno['nombre'] . ' ' . $alumno['apellido'] . ' (' . $alumno['codigo'] . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('id_alumno')): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo session()->getFlashdata('validation')->getError('id_alumno'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="id_carrera" class="form-label"><i class="bi bi-building"></i> Carrera *</label>
                            <select class="form-select <?php echo session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('id_carrera') ? 'is-invalid' : ''; ?>" 
                                    id="id_carrera" name="id_carrera" required>
                                <option value="">-- Seleccionar carrera --</option>
                                <?php foreach ($carreras as $carrera): ?>
                                    <option value="<?php echo $carrera['id']; ?>" 
                                            <?php echo old('id_carrera') == $carrera['id'] ? 'selected' : ''; ?>>
                                        <?php echo esc($carrera['nombre_carrera']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('id_carrera')): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo session()->getFlashdata('validation')->getError('id_carrera'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Asignar
                            </button>
                            <a href="<?php echo base_url('alumno_carrera'); ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('alumnoCarreraForm');
        // Validación Bootstrap 5
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>

<?php echo $this->endSection(); ?>
