@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mensaje</h2>
    <p><strong>Nombre:</strong> {{ $message->name }}</p>
    <p><strong>Email:</strong> {{ $message->email }}</p>
    <p><strong>Asunto:</strong> {{ $message->subject }}</p>
    <p><strong>Mensaje:</strong></p>
    <p>{{ $message->message }}</p>
    <a href="{{ route('messages.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
