@extends('partials.layout')

@section('content')
    <div class="container py-4">
        <h2 class="text-center text-light mb-4">📩 Mensajes Recibidos</h2>

        <div class="table-responsive">
            <table class="table table-dark table-hover table-striped rounded-3 overflow-hidden">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">📌 Asunto</th>
                        <th scope="col">👤 Nombre</th>
                        <th scope="col" class="text-center">📖 Estado</th>
                        <th scope="col" class="text-center">⚙️ Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                        <tr class="{{ $message->readed ? 'text-muted' : 'fw-bold' }}">
                            <td class="align-middle">{{ $message->subject }}</td>
                            <td class="align-middle">{{ $message->name }}</td>
                            <td class="align-middle text-center">
                                @if ($message->readed)
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Leído</span>
                                @else
                                    <span class="badge bg-warning"><i class="bi bi-envelope"></i> No leído</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="{{ route('messages.show', $message->id) }}"
                                            class="btn btn-info btn-sm w-100">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <form action="{{ route('messages.destroy', $message->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100"
                                                onclick="return confirm('¿Estás seguro de eliminar este mensaje?')">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver al inicio
            </a>
        </div>
    </div>
@endsection
