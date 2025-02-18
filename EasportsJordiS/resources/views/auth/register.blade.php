@extends('partials.layout')

@section('title', 'Registro')

@section('content')
    <h2>Registro</h2>
    <div>
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div>
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required placeholder="Introduce tu nombre">
            </div>

            <div>
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required placeholder="Introduce tu correo">
            </div>

            <div>
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="Introduce tu contraseña">
            </div>

            <div>
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirma tu contraseña">
            </div>

            <div>
                <label for="birthday">Fecha de Nacimiento</label>
                <input type="date" id="birthday" name="birthday" required>
            </div>

            <button type="submit">Registrarse</button>
        </form>

        <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
    </div>

@endsection

