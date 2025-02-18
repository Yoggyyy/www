@extends('partials.layout')

@section('title', 'Contacto')

@section('content')
    <h2>Contacto</h2>
    <form action="{{ route('contact.send') }}" method="POST">
        @csrf
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Mensaje</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Enviar</button>
    </form>
@endsection
