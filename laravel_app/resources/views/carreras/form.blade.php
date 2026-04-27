<div class="row g-3 mb-3">
    <div class="col-md-6"><label>Codigo</label><input name="codigo_carrera" class="form-control" value="{{ old('codigo_carrera', $carrera->codigo_carrera ?? '') }}"></div>
    <div class="col-md-6"><label>Nombre</label><input name="nombre_carrera" class="form-control" value="{{ old('nombre_carrera', $carrera->nombre_carrera ?? '') }}"></div>
</div>
