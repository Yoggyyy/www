@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Eventos</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Crear Nuevo Evento</a>

    @if($events->count() > 0)
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->nombre }}</h5>
                            <p class="card-text"><strong>Ubicación:</strong> {{ $event->ubicacion }}</p>
                            <p class="card-text"><strong>Fecha:</strong> {{ $event->fecha }} - <strong>Hora:</strong> {{ $event->hora }}</p>
                            <p class="card-text">{{ Str::limit($event->descripcion, 100) }}</p>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-info">Ver Detalles</a>
                            @auth
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este evento?')">Eliminar</button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay eventos disponibles.</p>
    @endif
</div>
@endsection
