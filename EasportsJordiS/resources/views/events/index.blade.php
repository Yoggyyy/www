@extends('partials.layout')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Lista de Eventos</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('events.create') }}" class="btn btn-primary">Crear Nuevo Evento</a>
    </div>

    @if($events->count() > 0)
        <div class="event-grid">
            @foreach($events as $event)
                <div class="event-card">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text"><strong>Ubicación:</strong> {{ $event->location }}</p>
                            <p class="card-text"><strong>Fecha:</strong> {{ $event->date }} - <strong>Hora:</strong> {{ $event->hour }}</p>
                            <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
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
        <p class="text-center">No hay eventos disponibles.</p>
    @endif
</div>
@endsection

