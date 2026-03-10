<?php echo $this->extend('layouts/main');?>
<?php echo $this->section('content');?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1><i class="bi bi-mortarboard"></i> Sistema Académico</h1>
        <p class="text-muted mb-0">Accesos rápidos a los módulos solicitados</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-calendar-check"></i> Inscripción Docente</h5>
                    <p class="card-text">Registrar materias por docente con reglas de horario y límite.</p>
                    <a href="<?php echo base_url('horarios');?>" class="btn btn-primary">Ir al módulo</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-journal-bookmark"></i> Materias por Docente</h5>
                    <p class="card-text">Consultar la carga de materias inscritas por cada docente.</p>
                    <a href="<?php echo base_url('docentes');?>" class="btn btn-primary">Ver docentes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-people"></i> Alumnos por Materia</h5>
                    <p class="card-text">Visualizar alumnos inscritos en cada materia.</p>
                    <a href="<?php echo base_url('materias');?>" class="btn btn-primary">Ver materias</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>

