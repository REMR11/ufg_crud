@extends('layouts.main')

@section('title', 'Nueva inscripción')

@section('content')
    <h1 class="h4 mb-3">Registrar inscripción</h1>
    <form id="form-inscripcion-create" method="post" action="{{ route('inscripciones.store') }}">
        @csrf
        @include('inscripciones.form-create-lote')
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection

@push('scripts')
<script>
(function () {
    const form = document.getElementById('form-inscripcion-create');
    if (!form) return;

    const selects = form.querySelectorAll('select.inscripcion-linea-horario');
    const alertDup = document.getElementById('inscripcion-duplicados-client');

    function validarHorariosDuplicados() {
        const indicesPorValor = new Map();
        selects.forEach(function (sel, idx) {
            var v = sel.value;
            if (v === '') return;
            if (!indicesPorValor.has(v)) indicesPorValor.set(v, []);
            indicesPorValor.get(v).push(idx);
        });

        var hayDuplicados = false;
        selects.forEach(function (s) {
            s.classList.remove('is-invalid');
        });

        indicesPorValor.forEach(function (indices) {
            if (indices.length > 1) {
                hayDuplicados = true;
                indices.forEach(function (i) {
                    selects[i].classList.add('is-invalid');
                });
            }
        });

        if (alertDup) {
            alertDup.classList.toggle('d-none', !hayDuplicados);
        }

        return !hayDuplicados;
    }

    selects.forEach(function (sel) {
        sel.addEventListener('change', validarHorariosDuplicados);
        sel.addEventListener('input', validarHorariosDuplicados);
    });

    function inicializar() {
        validarHorariosDuplicados();
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', inicializar);
    } else {
        inicializar();
    }

    form.addEventListener('submit', function (e) {
        if (!validarHorariosDuplicados()) {
            e.preventDefault();
            e.stopPropagation();
            if (alertDup) {
                alertDup.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }
    }, true);
})();
</script>
@endpush
