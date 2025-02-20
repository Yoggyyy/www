@extends('partials.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Panel de Administración</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Gestión de Eventos -->
        <div class="col-md-4">
            <div class="card text-bg-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Gestión de Eventos</h5>
                    <p class="card-text">Administra los eventos del equipo.</p>
                    <a href="{{ route('events.index') }}" class="btn btn-light">Ir a Eventos</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Jugadores -->
        <div class="col-md-4">
            <div class="card text-bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Gestión de Jugadores</h5>
                    <p class="card-text">Administra los jugadores del equipo.</p>
                    <a href="{{ route('players.index') }}" class="btn btn-light">Ir a Jugadores</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Mensajes -->
        <div class="col-md-4">
            <div class="card text-bg-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Gestión de Mensajes</h5>
                    <p class="card-text">Revisa y responde mensajes.</p>
                    <a href="{{ route('messages.index') }}" class="btn btn-light">Ir a Mensajes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
