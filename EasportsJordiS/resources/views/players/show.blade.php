@extends('partials.layout')

@section('content')
<div class="container text-center player-profile">
    <div class="player-header">
        <img src="{{ Storage::url($player->avatar) }}" class="player-avatar" alt="{{ $player->name }}">
        <h1>{{ $player->name }}</h1>
    </div>

    <div class="player-info">
        <h3>Información del Jugador</h3>
        <p><strong>Equipo:</strong> Misfits Gaming</p>
        <p><strong>Juego:</strong> League of Legends</p>
        <p><strong>Nombre:</strong> {{ $player->name }}</p>
        <p><strong>Visibilidad:</strong> {{ $player->visible ? 'Visible' : 'Oculto' }}</p>
    </div>

    <!-- Redes Sociales -->
    <div class="player-socials">
        <h3>Redes Sociales</h3>
        <div class="social-icons">
            @if($player->twitter)
                <a href="https://twitter.com/{{ $player->twitter }}" target="_blank">
                    <img src="{{ asset('images/icons/twitter.png') }}" alt="Twitter">
                </a>
            @endif
            @if($player->instagram)
                <a href="https://www.instagram.com/{{ $player->instagram }}" target="_blank">
                    <img src="{{ asset('images/icons/instagram.png') }}" alt="Instagram">
                </a>
            @endif
            @if($player->twitch)
                <a href="https://www.twitch.tv/{{ $player->twitch }}" target="_blank">
                    <img src="{{ asset('images/icons/twitch.png') }}" alt="Twitch">
                </a>
            @endif
        </div>
    </div>

    <!-- Acciones para Admin -->
    @auth
        @if(auth()->user()->rol === 'admin')
            <div class="admin-actions mt-4">
                <h3>Acciones de Administrador</h3>

                <!-- Toggle Visibility Form -->
                <form action="{{ route('players.visibility', $player) }}" method="POST" class="d-inline mb-2">
                    @csrf
                    <button type="submit" class="btn {{ $player->visible ? 'btn-warning' : 'btn-success' }}">
                        {{ $player->visible ? 'Ocultar' : 'Mostrar' }}
                    </button>
                </form>

                <!-- Delete Form -->
                <form action="{{ route('players.destroy', $player) }}" method="POST" class="d-inline ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este jugador?')">Eliminar</button>
                </form>
            </div>
        @endif
    @endauth

    <!-- Botón Volver -->
    <div class="player-actions mt-4">
        <a href="{{ route('players.index') }}" class="btn btn-outline-secondary">Volver a la Lista</a>
    </div>
</div>
@endsection
