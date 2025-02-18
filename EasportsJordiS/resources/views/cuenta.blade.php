@extends('partials.layout')

@section('content')
<div class="container text-center user-profile">
    <h1 class="my-4">Mi Cuenta</h1>

    @auth
    <div class="user-info">
        <img src="{{ asset('images/default-avatar.png') }}" class="user-avatar" alt="Avatar">
        <h3>{{ auth()->user()->name }}</h3>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Rol:</strong> {{ auth()->user()->role }}</p>

        <!-- Si el usuario es admin, mostramos opciones extra -->
        @if(auth()->user()->role === 'admin')
            <div class="admin-options">
                <h3>Opciones de Administrador</h3>
                <a href="{{ route('players.index') }}" class="btn btn-info">Gestionar Jugadores</a>
                <a href="{{ route('users.index') }}" class="btn btn-danger">Gestionar Usuarios</a>
            </div>
        @endif
    </div>

    <!-- Botón para cerrar sesión -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-light">Cerrar Sesión</button>
    </form>

    <!-- Botón para eliminar cuenta -->
    <form action=""{{ route('account.delete') }}" method="POST" class="delete-account-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.')">
            Eliminar Cuenta
        </button>
    </form>

    @else
        <p>Debes estar autenticado para ver esta página.</p>
        <a href="{{ route('login') }}" class="btn btn-transition btn-primary">Iniciar Sesión</a>
    @endauth
</div>
@endsection

