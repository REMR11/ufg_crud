<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-book"></i> Listado de Materias</h1>
    </div>

    <!-- Tabla con DataTables -->
    <?php if (!empty($materias)): ?>
        <div class="table-responsive">
            <table id="materiasTable" class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($materias as $materia): ?>
                        <tr>
                            <td><?php echo esc($materia['id_materia']);?></td>
                            <td><?php echo esc($materia['nombre_materia']);?></td>
                            <td>
                                <a href="<?php echo base_url('materias/' . $materia['id_materia'] . '/alumnos');?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-people"></i> Ver Alumnos
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No hay materias registradas.
        </div>
    <?php endif;?>
</div>

<?php echo $this->endSection();?>
