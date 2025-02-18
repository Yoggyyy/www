<nav class="navbar">
    <ul>
        <li><a href="{{ route('home') }}">Inicio</a></li>
        <li><a href="{{ route('events.index') }}">Eventos</a></li>
        <li><a href="{{ route('players.index') }}">Jugadores</a></li>
        <li><a href="{{ route('contact') }}">Contacto</a></li>

        @auth
            <li><a href="{{ route('account') }}">Cuenta</a></li>

            @if(auth()->user()->rol === 'admin')
                <li><a href="{{ route('players.create') }}">Añadir Jugador</a></li>
                <li><a href="{{ route('events.create') }}">Añadir Evento</a></li>
            @endif

            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Cerrar Sesión</button>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
            <li><a href="{{ route('register') }}">Registro</a></li>
        @endauth
    </ul>
</nav>



