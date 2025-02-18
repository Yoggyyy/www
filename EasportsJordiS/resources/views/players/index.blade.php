@extends('partials.layout')

@section('content')
    <div class="container text-center">
        <h1 class="my-4">Jugadores de Misfits Gaming</h1>

        <div class="players-grid">
            @foreach ($players as $player)
                @if ($player->visible)
                    <div class="player-card">
                        <img src="{{ Storage::url($player->avatar) . '.png'}} " class="card-img-top"
                            alt="{{ $player->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $player->name }}</h5>

                            <!-- Redes Sociales -->
                            <div class="player-socials">
                                @if ($player->twitter)
                                    <a href="https://twitter.com/{{ $player->twitter }}" target="_blank">
                                        <img src="{{ asset('images/icons/twitter.png') }}" alt="Twitter">
                                    </a>
                                @endif
                                @if ($player->facebook)
                                    <a href="https://www.facebook.com/{{ $player->facebook }}" target="_blank">
                                        <img src="{{ asset('images/icons/facebook.png') }}" alt="Facebook">
                                    </a>
                                @endif
                                @if ($player->instagram)
                                    <a href="https://www.instagram.com/{{ $player->instagram }}" target="_blank">
                                        <img src="{{ asset('images/icons/instagram.png') }}" alt="Instagram">
                                    </a>
                                @endif
                                @if ($player->twitch)
                                    <a href="https://www.twitch.tv/{{ $player->twitch }}" target="_blank">
                                        <img src="{{ asset('images/icons/twitch.png') }}" alt="Twitch">
                                    </a>
                                @endif
                            </div>


                            <!-- Botón para ver perfil -->
                            <a href="{{ route('players.show', $player->id) }}" class="btn-profile">
                                Ver Perfil
                            </a>

                            @auth
                                @if (Auth::user()->role === 'admin')
                                    <div class="admin-controls">
                                        @if ($player->visible)
                                            <a href="{{ route('players.toggleVisibility', $player->id) }}"
                                                class="btn btn-danger">Ocultar</a>
                                        @else
                                            <a href="{{ route('players.toggleVisibility', $player->id) }}"
                                                class="btn btn-success">Mostrar</a>
                                        @endif
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
