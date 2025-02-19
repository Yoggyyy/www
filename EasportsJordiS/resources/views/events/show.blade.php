@extends('partials.layout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card bg-dark text-light shadow-lg border-0 rounded-3 p-4 w-75 w-md-50">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mb-0">{{ $event->name }}</h1>
                    <span
                        class="badge bg-{{ $event->type === 'official' ? 'primary' : ($event->type === 'exhibition' ? 'success' : 'warning') }}">
                        {{ ucfirst($event->type) }}
                    </span>
                </div>

                <div class="row mb-4">
                        <h5><i class="bi bi-geo-alt text-warning"></i> Ubicación</h5>
                        <p>{{ $event->location }}</p>

                        <h5><i class="bi bi-calendar-check text-info"></i> Fecha y Hora</h5>
                        <p>
                            {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                            a las {{ \Carbon\Carbon::parse($event->hour)->format('H:i') }}
                        </p>

                        <h5><i class="bi bi-tags text-secondary"></i> Etiquetas</h5>
                        <p>
                            @foreach (explode(',', $event->tags) as $tag)
                                <span class="badge bg-secondary">{{ trim($tag) }}</span>
                            @endforeach
                        </p>

                        <div id="countdown" class="alert alert-info rounded-3">
                            <h5><i class="bi bi-clock-history"></i> Tiempo restante</h5>
                            <div id="countdown-timer" class="fw-bold fs-5">Calculando...</div>
                        </div>
                </div>

                <div class="mb-4">
                    <h5><i class="bi bi-file-text text-light"></i> Descripción</h5>
                    <p class="lead">{{ $event->description }}</p>
                </div>

                @auth
                    <div class="row text-center mt-4">
                        @if (auth()->user()->rol === 'admin')
                            <div class="col-4">
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning w-100">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                            </div>
                            <div class="col-4">
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('¿Estás seguro de eliminar este evento?')">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        @endif
                        <div class="col-4">
                            <button class="btn btn-outline-light w-100 like-button" data-event-id="{{ $event->id }}"
                                data-liked="{{ $event->usersWhoLiked->contains(auth()->id()) }}">
                                <i class="bi bi-heart{{ $event->usersWhoLiked->contains(auth()->id()) ? '-fill' : '' }}"></i>
                                <span class="likes-count">{{ $event->usersWhoLiked->count() }}</span>
                            </button>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateCountdown() {
                const eventDate = new Date('{{ $event->date }} {{ $event->hour }}').getTime();
                const now = new Date().getTime();
                const distance = eventDate - now;

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                const countdownElement = document.getElementById('countdown-timer');

                if (distance < 0) {
                    countdownElement.innerHTML = '¡El evento ya ha comenzado!';
                    document.getElementById('countdown').classList.remove('alert-info');
                    document.getElementById('countdown').classList.add('alert-warning');
                } else {
                    countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                }
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();

            document.addEventListener('DOMContentLoaded', function() {
                const likeButton = document.querySelector('.like-button');
                if (likeButton) {
                    likeButton.addEventListener('click', async function() {
                        try {
                            const response = await fetch(`/events/${this.dataset.eventId}/like`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });

                            const data = await response.json();
                            const icon = this.querySelector('i');
                            const countSpan = this.querySelector('.likes-count');

                            if (data.liked) {
                                icon.classList.remove('bi-heart');
                                icon.classList.add('bi-heart-fill');
                                countSpan.textContent = parseInt(countSpan.textContent) + 1;
                            } else {
                                icon.classList.remove('bi-heart-fill');
                                icon.classList.add('bi-heart');
                                countSpan.textContent = parseInt(countSpan.textContent) - 1;
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Ha ocurrido un error al procesar tu solicitud');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
