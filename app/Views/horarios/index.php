<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-calendar-check"></i> Inscripción de Docentes a Materias</h1>
        <a href="<?php echo base_url('horarios/create');?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Horario
        </a>
    </div>

    <!-- Mensajes de éxito/error -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <?php echo session()->getFlashdata('success');?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif;?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle"></i> <?php echo session()->getFlashdata('error');?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif;?>

    <!-- Búsqueda y filtros -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="get" class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Buscar por materia..." 
                       value="<?php echo esc($search);?>">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <?php if (!empty($search) || !empty($filtro_docente)): ?>
                    <a href="<?php echo base_url('horarios');?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i> Limpiar
                    </a>
                <?php endif;?>
            </form>
        </div>
        <div class="col-md-6">
            <form method="get" class="input-group">
                <span class="input-group-text"><i class="bi bi-funnel"></i> Filtrar por Docente:</span>
                <select class="form-select" name="filtro_docente" id="filtroDocente">
                    <option value="">Todos los Docentes</option>
                    <?php foreach ($docentes as $docente): ?>
                        <option value="<?php echo esc($docente['id']);?>" 
                                <?php echo ($filtro_docente == $docente['id']) ? 'selected' : '';?>>
                            <?php echo esc($docente['nombre'] . ' ' . $docente['apellido']);?>
                        </option>
                    <?php endforeach;?>
                </select>
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
            </form>
        </div>
    </div>

    <!-- Tabla con DataTables -->
    <?php if (!empty($horarios)): ?>
        <div class="table-responsive">
            <table id="horariosTable" class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Docente</th>
                        <th>Materia</th>
                        <th>Día</th>
                        <th>Bloque</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Duración</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horarios as $horario): 
                        // Calcular duración en horas
                        $inicio = new DateTime($horario['hora_inicio']);
                        $fin = new DateTime($horario['hora_fin']);
                        $intervalo = $inicio->diff($fin);
                        $horas = $intervalo->h;
                        $minutos = $intervalo->i;
                        $duracion = ($horas > 0) ? $horas . 'h' : '';
                        if ($minutos > 0) {
                            $duracion .= ($duracion ? ' ' : '') . $minutos . 'min';
                        }
                    ?>
                        <tr>
                            <td><?php echo esc($horario['id']);?></td>
                            <td>
                                <span class="badge bg-info">
                                    <?php echo esc($horario['nombre_docente']);?>
                                </span>
                            </td>
                            <td><?php echo esc($horario['nombre_materia']);?></td>
                            <td>
                                <span class="badge bg-secondary text-uppercase">
                                    <?php echo esc(substr($horario['dia'], 0, 3));?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-dark text-uppercase">
                                    <?php echo esc($horario['bloque'] ?? '-');?>
                                </span>
                            </td>
                            <td><?php echo esc($horario['hora_inicio']);?></td>
                            <td><?php echo esc($horario['hora_fin']);?></td>
                            <td>
                                <span class="badge bg-primary">
                                    <?php echo esc($duracion);?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?php echo base_url('horarios/show/' . $horario['id']);?>" 
                                       class="btn btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo base_url('horarios/edit/' . $horario['id']);?>" 
                                       class="btn btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?php echo base_url('horarios/delete/' . $horario['id']);?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('¿Estás seguro de que deseas eliminar este horario?');" 
                                       title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i> No hay horarios registrados. 
            <a href="<?php echo base_url('horarios/create');?>" class="alert-link">Crear uno ahora</a>
        </div>
    <?php endif;?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTables
        $('#horariosTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            pageLength: 10,
            order: [[1, 'asc'], [3, 'asc'], [4, 'asc']]
        });
    });
</script>

<?php echo $this->endSection();?>
