@extends('partials.layout')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4 text-center text-light">Lista de Eventos</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @auth
            @if (auth()->user()->rol === 'admin')
                <div class="mb-3 text-center">
                    <a href="{{ route('events.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Crear Nuevo Evento
                    </a>
                </div>
            @endif
        @endauth

        @if ($events->count() > 0)
            <div class="row g-4">
                @foreach ($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 bg-dark text-light shadow-lg border-0 rounded-3">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $event->name }}</h5>
                                <p class="card-text">
                                    <i class="bi bi-geo-alt-fill text-warning"></i> {{ $event->location }}
                                </p>
                                <p class="card-text">
                                    <i class="bi bi-calendar-check-fill text-info"></i>
                                    {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                    <i class="bi bi-clock-fill text-danger ms-2"></i>
                                    {{ \Carbon\Carbon::parse($event->hour)->format('H:i') }}
                                </p>
                                <p class="card-text text-truncate">{{ $event->description }}</p>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm text-light">
                                        <i class="bi bi-eye"></i> Ver Detalles
                                    </a>

                                    @auth
                                        <div class="btn-group">
                                            @if (auth()->user()->rol === 'admin')
                                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                                <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Estás seguro de eliminar este evento?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('events.like', $event->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-light btn-sm ms-3">
                                                    @if ($event->likes->contains(Auth::user()))
                                                        <i class="bi bi-heart-fill text-danger"></i>
                                                    @else
                                                        <i class="bi bi-heart text-white"></i>
                                                    @endif
                                                    <span class="ms-1">{{ $event->likes->count() }}</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-secondary text-center">
                <i class="bi bi-info-circle"></i> No hay eventos disponibles en este momento.
            </div>
        @endif
    </div>
@endsection
