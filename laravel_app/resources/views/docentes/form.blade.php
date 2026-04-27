<div class="row g-3 mb-3">
    <div class="col-md-6"><label>Nombre</label><input name="nombre" class="form-control" value="{{ old('nombre', $docente->nombre ?? '') }}"></div>
    <div class="col-md-6"><label>Apellido</label><input name="apellido" class="form-control" value="{{ old('apellido', $docente->apellido ?? '') }}"></div>
    <div class="col-md-6"><label>Email</label><input name="email" class="form-control" value="{{ old('email', $docente->email ?? '') }}"></div>
    <div class="col-md-6"><label>Telefono</label><input name="telefono" class="form-control" value="{{ old('telefono', $docente->telefono ?? '') }}"></div>
</div>
