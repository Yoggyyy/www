@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mensajes Recibidos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Asunto</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $message)
                <tr>
                    <td>{{ $message->subject }}</td>
                    <td>{{ $message->name }}</td>
                    <td>
                        <a href="{{ route('messages.show', $message->id) }}" class="btn btn-info">Ver</a>
                        <form action="{{ route('messages.destroy', $message->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
