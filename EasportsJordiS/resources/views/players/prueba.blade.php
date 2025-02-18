@extends('partials.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Jugadores</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('players.create') }}" class="btn btn-primary mb-3">Añadir Nuevo Jugador</a>

    @if($players->count() > 0)
        <div class="row">
            @foreach($players as $player)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ $player->avatar ? asset('storage/' . $player->avatar) : asset('images/default-avatar.png') }}" class="card-img-top" alt="Avatar del jugador">
                        <div class="card-body">
                            <h5 class="card-title">{{ $player->nombre }}</h5>
                            <p class="card-text"><strong>Redes Sociales:</strong> {{ $player->redes_sociales }}</p>
                            <p class="card-text"><strong>Estado:</strong> {{ $player->visible ? 'Visible' : 'Oculto' }}</p>
                            <a href="{{ route('players.show', $player->id) }}" class="btn btn-info">Ver Perfil</a>
                            @auth
                                <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este jugador?')">Eliminar</button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay jugadores disponibles.</p>
    @endif
</div>
@endsection
