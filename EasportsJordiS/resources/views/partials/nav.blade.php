<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Logo a la izquierda -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
        </a>

        <!-- Botón Hamburguesa en móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú principal -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Eventos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('players.index') }}">Jugadores</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contacto</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('where') }}">Dónde Estamos</></li>

                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('account') }}">Cuenta</a></li>
                @endauth
            </ul>
        </div>

        <!-- Cerrar sesión alineado a la derecha -->
        <div class="d-flex">
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Cerrar Sesión</button>
                </form>
            @endauth
            @auth
                @if (auth()->user()->rol === 'admin')
                    <div class="admin-navbar bg-secondary text-center py-2">
                        <a href="{{ route('players.create') }}" class="btn btn-light mx-2">Añadir Jugador</a>
                        <a href="{{ route('events.create') }}" class="btn btn-light mx-2">Añadir Evento</a>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</nav>
