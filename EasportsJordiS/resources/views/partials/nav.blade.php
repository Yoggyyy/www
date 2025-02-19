<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <!-- Logo y nombre -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('logo.png') }}" alt="Logo" height="50">
        </a>

        <!-- Botón hamburguesa para móvil -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú principal -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Enlaces centrales -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                        href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i>Inicio
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'events.index' ? 'active' : '' }}"
                        href="{{ route('events.index') }}">
                        <i class="bi bi-calendar-event me-1"></i>Eventos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'players.index' ? 'active' : '' }}"
                        href="{{ route('players.index') }}">
                        <i class="bi bi-people me-1"></i>Jugadores
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'contact' ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        <i class="bi bi-envelope me-1"></i>Contacto
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'where' ? 'active' : '' }}"
                        href="{{ route('where') }}">
                        <i class="bi bi-geo-alt me-1"></i>Dónde Estamos
                    </a>
                </li>
            </ul>

            <!-- Botones de autenticación -->
            <div class="ms-auto d-flex align-items-end gap-2">
                <div class="ms-auto d-flex align-items-center gap-2">
                    @guest
                        <!-- Botones para usuarios no autenticados -->
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-person-plus me-1"></i>Registrarse
                        </a>
                    @else
                        <!-- Menú para usuarios autenticados -->
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle d-flex align-items-center" type="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                <!-- Opciones de administrador -->
                                @if (Auth::user()->rol === 'admin')
                                    <li>
                                        <h6 class="dropdown-header">Administración</h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('events.create') }}">
                                            <i class="bi bi-plus-circle me-2"></i>Nuevo Evento
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('players.create') }}">
                                            <i class="bi bi-person-plus me-2"></i>Nuevo Jugador
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('messages.index') }}">
                                            <i class="bi bi-envelope me-2"></i>Ver Mensajes
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif

                                <!-- Opciones de usuario -->
                                <li>
                                    <a class="dropdown-item" href="{{ route('account') }}">
                                        <i class="bi bi-gear me-2"></i>Mi Cuenta
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<style>
    /* Estilos para mejorar la apariencia del nav */
    .navbar {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .nav-link {
        position: relative;
        padding: 0.5rem 1rem;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        left: 1rem;
        right: 1rem;
        bottom: 0;
        height: 2px;
        background-color: var(--bs-primary);
    }

    .nav-link:hover {
        color: var(--bs-primary) !important;
    }

    .dropdown-item:active {
        background-color: var(--bs-primary);
    }

    /* Animación para el botón hamburguesa */
    .navbar-toggler:focus {
        box-shadow: none;
    }

    /* Mejoras para dispositivos móviles */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            padding: 1rem 0;
        }

        .navbar-nav {
            margin: 1rem 0;
        }

        .nav-link.active::after {
            display: none;
        }

        .nav-link.active {
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 0.25rem;
        }
    }
</style>
