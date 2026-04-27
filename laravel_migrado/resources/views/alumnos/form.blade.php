<div class="row g-3 mb-3">
    <div class="col-md-6"><label class="form-label">Nombre</label><input name="nombre" class="form-control" value="{{ old('nombre', $alumno->nombre ?? '') }}"></div>
    <div class="col-md-6"><label class="form-label">Apellido</label><input name="apellido" class="form-control" value="{{ old('apellido', $alumno->apellido ?? '') }}"></div>
    <div class="col-md-6"><label class="form-label">Email</label><input name="email" class="form-control" value="{{ old('email', $alumno->email ?? '') }}"></div>
    <div class="col-md-6"><label class="form-label">Telefono</label><input name="telefono" class="form-control" value="{{ old('telefono', $alumno->telefono ?? '') }}"></div>
    <div class="col-md-6"><label class="form-label">Codigo</label><input name="codigo" class="form-control" value="{{ old('codigo', $alumno->codigo ?? '') }}"></div>
    <div class="col-md-6">
        <label class="form-label">Carrera</label>
        <select name="codigo_carrera" class="form-select">
            <option value="">Seleccione</option>
            @foreach($carreras as $carrera)
                <option value="{{ $carrera->id }}" @selected((string) old('codigo_carrera', $alumno->codigo_carrera ?? '') === (string) $carrera->id)>{{ $carrera->nombre_carrera }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12"><label class="form-label">Foto</label><input type="file" name="foto" class="form-control"></div>
</div>
