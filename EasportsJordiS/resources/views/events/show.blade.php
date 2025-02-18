@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $event->nombre }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><strong>Ubicación:</strong> {{ $event->ubicacion }}</h5>
            <p class="card-text"><strong>Fecha:</strong> {{ $event->fecha }} - <strong>Hora:</strong> {{ $event->hora }}</p>
            <p class="card-text"><strong>Tipo:</strong> {{ $event->tipo }}</p>
            <p class="card-text"><strong>Etiquetas:</strong> {{ $event->etiquetas }}</p>
            <p class="card-text"><strong>Descripción:</strong> {{ $event->descripcion }}</p>

            @auth
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este evento?')">Eliminar</button>
                </form>
            @endauth

            <a href="{{ route('events.index') }}" class="btn btn-secondary">Volver a la Lista</a>
        </div>
    </div>
</div>
@endsection
