@extends('partials.layout')

@section('content')
    <div class="container py-4 d-flex justify-content-center">
        <div class="card bg-dark text-light shadow-lg border-0 rounded-3 p-4 w-100 col-md-8 col-lg-6">
            <div class="card-body">
                <h2 class="text-center mb-4">📩 Mensaje Recibido</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-dark text-light">
                        <strong>👤 Nombre:</strong> {{ $message->name }}
                    </li>

                    <li class="list-group-item bg-dark text-light">
                        <strong>📌 Asunto:</strong> {{ $message->subject }}
                    </li>
                    <li class="list-group-item bg-dark text-light">
                        <strong>📝 Mensaje:</strong>
                        <p class="mt-2">{{ $message->text }}</p>
                    </li>
                </ul>
                <div class="text-center mt-4">
                    <a href="{{ route('messages.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
