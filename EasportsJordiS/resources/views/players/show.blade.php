@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $player->nombre }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <img src="{{ $player->avatar ? asset('storage/' . $player->avatar) : asset('images/default-avatar.png') }}" class="card-img-top mx-auto d-block mt-3" style="max-width: 200px; border-radius: 50%;" alt="Avatar del jugador">
        <div class="card-body text-center">
            <h5 class="card-title">{{ $player->nombre }}</h5>
            <p class="card-text"><strong>Redes Sociales:</strong> {{ $player->redes_sociales }}</p>
            <p class="card-text"><strong>Estado:</strong> {{ $player->visible ? 'Visible' : 'Oculto' }}</p>

            @auth
                <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este jugador?')">Eliminar</button>
                </form>
            @endauth

            <a href="{{ route('players.index') }}" class="btn btn-secondary mt-3">Volver a la Lista</a>
        </div>
    </div>
</div>
@endsection
