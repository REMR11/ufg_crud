<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-plus"></i> Registrar Nuevo Horario de Docente
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

                    <!-- Mostrar errores generales -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-x-circle"></i> <?php echo session()->getFlashdata('error');?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif;?>

                    <form action="<?php echo base_url('horarios/store');?>" method="POST" id="formHorario">
                        <?php echo csrf_field();?>

                        <div class="alert alert-info mb-4" role="alert">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Nota importante:</strong> Cada docente puede inscribirse en máximo 5 materias. 
                            Se permite repetir materia en días distintos. El bloque (matutino/vespertino) se define automáticamente por hora.
                        </div>

                        <div class="mb-3">
                            <label for="id_docente" class="form-label">Docente <span class="text-danger">*</span></label>
                            <select class="form-select <?php echo (session('validation') && session('validation')->hasError('id_docente')) ? 'is-invalid' : '';?>" 
                                    id="id_docente" name="id_docente" required>
                                <option value="">-- Seleccionar Docente --</option>
                                <?php foreach ($docentes as $docente): ?>
                                    <option value="<?php echo esc($docente['id']);?>"
                                            <?php echo (old('id_docente') == $docente['id']) ? 'selected' : '';?>>
                                        <?php echo esc($docente['nombre'] . ' ' . $docente['apellido']);?> (<?php echo esc($docente['email']);?>)
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <?php if (session('validation') && session('validation')->hasError('id_docente')): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo session('validation')->getError('id_docente');?>
                                </div>
                            <?php endif;?>
                        </div>

                        <div class="mb-3">
                            <label for="id_materia" class="form-label">Materia <span class="text-danger">*</span></label>
                            <select class="form-select <?php echo (session('validation') && session('validation')->hasError('id_materia')) ? 'is-invalid' : '';?>" 
                                    id="id_materia" name="id_materia" required>
                                <option value="">-- Seleccionar Materia --</option>
                                <?php foreach ($materias as $materia): ?>
                                    <option value="<?php echo esc($materia['id_materia']);?>"
                                            <?php echo (old('id_materia') == $materia['id_materia']) ? 'selected' : '';?>>
                                        <?php echo esc($materia['nombre_materia']);?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <?php if (session('validation') && session('validation')->hasError('id_materia')): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo session('validation')->getError('id_materia');?>
                                </div>
                            <?php endif;?>
                        </div>

                        <div class="mb-3">
                            <label for="dia" class="form-label">Día de la Semana <span class="text-danger">*</span></label>
                            <select class="form-select <?php echo (session('validation') && session('validation')->hasError('dia')) ? 'is-invalid' : '';?>" 
                                    id="dia" name="dia" required>
                                <option value="">-- Seleccionar Día --</option>
                                <option value="lunes" <?php echo (old('dia') == 'lunes') ? 'selected' : '';?>>Lunes</option>
                                <option value="martes" <?php echo (old('dia') == 'martes') ? 'selected' : '';?>>Martes</option>
                                <option value="miercoles" <?php echo (old('dia') == 'miercoles') ? 'selected' : '';?>>Miércoles</option>
                                <option value="jueves" <?php echo (old('dia') == 'jueves') ? 'selected' : '';?>>Jueves</option>
                                <option value="viernes" <?php echo (old('dia') == 'viernes') ? 'selected' : '';?>>Viernes</option>
                                <option value="sabado" <?php echo (old('dia') == 'sabado') ? 'selected' : '';?>>Sábado</option>
                            </select>
                            <?php if (session('validation') && session('validation')->hasError('dia')): ?>
                                <div class="invalid-feedback d-block">
                                    <?php echo session('validation')->getError('dia');?>
                                </div>
                            <?php endif;?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hora_inicio" class="form-label">Hora de Inicio <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control <?php echo (session('validation') && session('validation')->hasError('hora_inicio')) ? 'is-invalid' : '';?>" 
                                           id="hora_inicio" name="hora_inicio" required
                                           value="<?php echo old('hora_inicio', '');?>"
                                           onchange="calcularHoraFin()">
                                    <?php if (session('validation') && session('validation')->hasError('hora_inicio')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?php echo session('validation')->getError('hora_inicio');?>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hora_fin" class="form-label">Hora de Finalización <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control <?php echo (session('validation') && session('validation')->hasError('hora_fin')) ? 'is-invalid' : '';?>" 
                                           id="hora_fin" name="hora_fin" required readonly
                                           value="<?php echo old('hora_fin', '');?>">
                                    <small class="form-text text-muted">Se calcula automáticamente (inicio + 2 horas)</small>
                                    <?php if (session('validation') && session('validation')->hasError('hora_fin')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?php echo session('validation')->getError('hora_fin');?>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bloque</label>
                            <input type="text" class="form-control" id="bloque_preview" value="Se calculará automáticamente" readonly>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Guardar
                            </button>
                            <a href="<?php echo base_url('horarios');?>" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function calcularHoraFin() {
    const horaInicio = document.getElementById('hora_inicio').value;
    if (horaInicio) {
        const [horas, minutos] = horaInicio.split(':').map(Number);
        const fecha = new Date();
        fecha.setHours(horas, minutos);
        fecha.setHours(fecha.getHours() + 2); // Agregar 2 horas
        
        const horaFin = String(fecha.getHours()).padStart(2, '0') + ':' + 
                       String(fecha.getMinutes()).padStart(2, '0');
        document.getElementById('hora_fin').value = horaFin;
        document.getElementById('bloque_preview').value = (horas < 12) ? 'matutino' : 'vespertino';
    } else {
        document.getElementById('bloque_preview').value = 'Se calculará automáticamente';
    }
}
</script>

<?php echo $this->endSection();?>
