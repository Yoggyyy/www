@extends('partials.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Nuevo Evento</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Evento</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación</label>
            <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" value="{{ old('hora') }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Evento</label>
            <select class="form-control" id="tipo" name="tipo" required>
                <option value="Torneo" {{ old('tipo') == 'Torneo' ? 'selected' : '' }}>Torneo</option>
                <option value="Entrenamiento" {{ old('tipo') == 'Entrenamiento' ? 'selected' : '' }}>Entrenamiento</option>
                <option value="Otro" {{ old('tipo') == 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="etiquetas" class="form-label">Etiquetas (separadas por comas)</label>
            <input type="text" class="form-control" id="etiquetas" name="etiquetas" value="{{ old('etiquetas') }}">
        </div>

        <div class="mb-3">
            <label for="visible" class="form-label">¿Visible al público?</label>
            <select class="form-control" id="visible" name="visible" required>
                <option value="1" {{ old('visible') == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('visible') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Evento</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

