<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label" for="nombre">Nombre</label>
        <input
            id="nombre"
            name="nombre"
            class="form-control @error('nombre') is-invalid @enderror"
            value="{{ old('nombre', $alumno->nombre ?? '') }}"
            minlength="2"
            maxlength="100"
            required
        >
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="apellido">Apellido</label>
        <input
            id="apellido"
            name="apellido"
            class="form-control @error('apellido') is-invalid @enderror"
            value="{{ old('apellido', $alumno->apellido ?? '') }}"
            minlength="2"
            maxlength="100"
            required
        >
        @error('apellido')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="email">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $alumno->email ?? '') }}"
            maxlength="100"
            required
        >
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="telefono">Telefono</label>
        <input
            id="telefono"
            type="text"
            name="telefono"
            class="form-control @error('telefono') is-invalid @enderror"
            value="{{ old('telefono', $alumno->telefono ?? '') }}"
            maxlength="8"
            pattern="[0-9]{8}"
            inputmode="numeric"
            placeholder="Ej: 71234567"
        >
        @error('telefono')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="codigo">Codigo</label>
        <input
            id="codigo"
            name="codigo"
            class="form-control @error('codigo') is-invalid @enderror"
            value="{{ old('codigo', $alumno->codigo ?? '') }}"
            maxlength="20"
            pattern="[A-Za-z0-9]+"
            required
        >
        @error('codigo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label" for="codigo_carrera">Carrera</label>
        <select id="codigo_carrera" name="codigo_carrera" class="form-select @error('codigo_carrera') is-invalid @enderror" required>
            <option value="">Seleccione</option>
            @foreach($carreras as $carrera)
                <option value="{{ $carrera->id }}" @selected((string) old('codigo_carrera', $alumno->codigo_carrera ?? '') === (string) $carrera->id)>{{ $carrera->nombre_carrera }}</option>
            @endforeach
        </select>
        @error('codigo_carrera')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
