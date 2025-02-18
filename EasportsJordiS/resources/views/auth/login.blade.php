@extends('partials.layout')

@section('title', 'Iniciar Sesión')

@section('content')
    <h2>Iniciar Sesión</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Ingresar</button>
    </form>

    <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
@endsection

