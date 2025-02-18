@extends('partials.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Jugador</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('players.update', $player->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Jugador</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $player->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="redes_sociales" class="form-label">Redes Sociales</label>
            <input type="text" class="form-control" id="redes_sociales" name="redes_sociales" value="{{ old('redes_sociales', $player->redes_sociales) }}">
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="avatar" name="avatar">
            @if($player->avatar)
                <p class="mt-2">Imagen actual:</p>
                <img src="{{ asset('storage/' . $player->avatar) }}" class="img-thumbnail" style="max-width: 150px;">
            @endif
        </div>

        <div class="mb-3">
            <label for="visible" class="form-label">¿Visible al público?</label>
            <select class="form-control" id="visible" name="visible" required>
                <option value="1" {{ old('visible', $player->visible) == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('visible', $player->visible) == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Jugador</button>
        <a href="{{ route('players.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
