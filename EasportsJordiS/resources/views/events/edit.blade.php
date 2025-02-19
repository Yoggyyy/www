@extends('partials.layout')

@section('content')
    <div class="container">
        <h1 class="mb-4">Editar Evento: {{ $event->name }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.update', $event->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- Campo Nombre -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre del Evento</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $event->name) }}" required maxlength="30">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Ubicación -->
                <div class="col-md-6">
                    <label for="location" class="form-label">Ubicación</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                        name="location" value="{{ old('location', $event->location) }}" required>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campos Fecha y Hora -->
                <div class="col-md-6">
                    <label for="date" class="form-label">Fecha</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                        name="date" value="{{ old('date', $event->date) }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="hour" class="form-label">Hora</label>
                    <input type="time" class="form-control @error('hour') is-invalid @enderror" id="hour"
                        name="hour" value="{{ old('hour', \Carbon\Carbon::parse($event->hour)->format('H:i')) }}"
                        required>
                    @error('hour')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Tipo -->
                <div class="col-md-6">
                    <label for="type" class="form-label">Tipo de Evento</label>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="official" {{ old('type', $event->type) == 'official' ? 'selected' : '' }}>Oficial
                        </option>
                        <option value="exhibition" {{ old('type', $event->type) == 'exhibition' ? 'selected' : '' }}>
                            Exhibición</option>
                        <option value="charity" {{ old('type', $event->type) == 'charity' ? 'selected' : '' }}>Benéfico
                        </option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Etiquetas -->
                <div class="col-md-6">
                    <label for="tags" class="form-label">Etiquetas</label>
                    <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags"
                        name="tags" value="{{ old('tags', $event->tags) }}" placeholder="Separadas por comas">
                    @error('tags')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Descripción -->
                <div class="col-12">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="4" required>{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Visibilidad -->
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="visible" name="visible"
                            {{ old('visible', $event->visible) ? 'checked' : '' }}>
                        <label class="form-check-label" for="visible">
                            Evento visible
                        </label>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Actualizar Evento
                    </button>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Script para validación del lado del cliente
            (function() {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>
    @endpush
@endsection
