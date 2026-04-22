<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-mortarboard"></i> Listado de Carreras</h1>
        <a href="<?php echo base_url('carreras/create');?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Carrera
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

    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <form method="get" class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Buscar por nombre o código..." 
                   value="<?php echo esc($search);?>">
            <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-search"></i> Buscar
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?php echo base_url('carreras');?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i> Limpiar
                </a>
            <?php endif;?>
        </form>
    </div>

    <!-- Tabla con DataTables -->
    <?php if (!empty($carreras)): ?>
        <div class="table-responsive">
            <table id="carrerasTable" class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carreras as $carrera): ?>
                        <tr>
                            <td><?php echo esc($carrera['codigo_carrera']);?></td>
                            <td><?php echo esc($carrera['nombre_carrera']);?></td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?php echo base_url('carreras/show/' . $carrera['id']);?>" 
                                       class="btn btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo base_url('carreras/edit/' . $carrera['id']);?>" 
                                       class="btn btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?php echo base_url('carreras/delete/' . $carrera['id']);?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('¿Estás seguro de que deseas eliminar esta carrera?');" 
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
            <i class="bi bi-info-circle"></i> No hay carreras registradas. 
            <a href="<?php echo base_url('carreras/create');?>" class="alert-link">Crear una ahora</a>
        </div>
    <?php endif;?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTables
        $('#carrerasTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            pageLength: 10,
            order: [[0, 'asc']]
        });
    });
</script>

<?php echo $this->endSection();?>
