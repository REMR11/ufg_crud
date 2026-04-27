<?php echo $this->extend('layouts/main'); ?>
<?php echo $this->section('content'); ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-link-45deg"></i> Asignación Alumno-Carrera</h1>
        <a href="<?php echo base_url('alumno_carrera/create'); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Asignación
        </a>
    </div>

    <!-- Mensajes de éxito/error -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <?php echo session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle"></i> <?php echo session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-6">
                    <label for="search" class="form-label"><i class="bi bi-search"></i> Buscar Alumno</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Nombre, apellido, email o código..." 
                           value="<?php echo esc($search); ?>">
                </div>

                <div class="col-md-4">
                    <label for="id_carrera" class="form-label"><i class="bi bi-building"></i> Filtrar por Carrera</label>
                    <select class="form-select" id="id_carrera" name="id_carrera">
                        <option value="">-- Todas las carreras --</option>
                        <?php foreach ($carreras as $carrera): ?>
                            <option value="<?php echo $carrera['id']; ?>" 
                                    <?php echo $idCarrera == $carrera['id'] ? 'selected' : ''; ?>>
                                <?php echo esc($carrera['nombre_carrera']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-outline-primary flex-grow-1" type="submit">
                        <i class="bi bi-funnel"></i> Filtrar
                    </button>
                    <?php if (!empty($search) || !empty($idCarrera)): ?>
                        <a href="<?php echo base_url('alumno_carrera'); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i> Limpiar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla con DataTables -->
    <?php if (!empty($alumnoCarrera)): ?>
        <div class="table-responsive">
            <table id="alumnoCarreraTable" class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Alumno</th>
                        <th>Código</th>
                        <th>Email</th>
                        <th>Carrera</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alumnoCarrera as $registro): ?>
                        <tr>
                            <td><?php echo $registro['id']; ?></td>
                            <td><?php echo esc($registro['nombre'] . ' ' . $registro['apellido']); ?></td>
                            <td><?php echo esc($registro['codigo']); ?></td>
                            <td><?php echo esc($registro['email']); ?></td>
                            <td><?php echo esc($registro['nombre_carrera']); ?></td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?php echo base_url('alumno_carrera/show/' . $registro['id']); ?>" 
                                       class="btn btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo base_url('alumno_carrera/edit/' . $registro['id']); ?>" 
                                       class="btn btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?php echo base_url('alumno_carrera/delete/' . $registro['id']); ?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('¿Está seguro de eliminar esta asignación?');"
                                       title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Script para inicializar DataTables -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new DataTable('#alumnoCarreraTable', {
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
                    },
                    pageLength: 10,
                    order: [[0, 'desc']],
                    columnDefs: [
                        { orderable: false, targets: 5 } // Columna de acciones no ordenable
                    ]
                });
            });
        </script>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i> No hay asignaciones registradas. 
            <a href="<?php echo base_url('alumno_carrera/create'); ?>">Crear una nueva</a>
        </div>
    <?php endif; ?>
</div>

<?php echo $this->endSection(); ?>
