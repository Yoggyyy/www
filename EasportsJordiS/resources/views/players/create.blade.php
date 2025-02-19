@extends('partials.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Añadir Nuevo Jugador</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('players.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Jugador</label>
            <input type="text" class="form-control" id="nombre" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="redes_sociales" class="form-label">Redes Sociales</label>
            <input type="text" class="form-control" id="redes_sociales" name="social-media" value="{{ old('social-media') }}">
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" class="form-control" id="position" name="position" value="{{ old('position') }}">
        </div>
        <div class="mb-3">
            <label for="team" class="form-label">Equipo</label>
            <input type="text" class="form-control" id="team" name="team" value="{{ old('team') }}">
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Edad</label>
            <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}">
        </div>

        <div class="mb-3">
            <label for="victory" class="form-label">Victorias</label>
            <input type="number" class="form-control" id="victory" name="victory" value="{{ old('victory') }}">
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file" class="form-control" id="avatar" name="avatar">
        </div>

        <div class="mb-3">
            <label for="visible" class="form-label">¿Visible al público?</label>
            <select class="form-control" id="visible" name="visible" required>
                <option value="1" {{ old('visible') == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('visible') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Jugador</button>
        <a href="{{ route('players.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

