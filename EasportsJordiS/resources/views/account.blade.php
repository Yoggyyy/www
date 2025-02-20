@extends('partials.layout')

@section('content')
    <div class="container-fluid py-5">
        <div class="row justify-content-center px-5">
            <div class="col-xxl-8 col-xl-9 col-lg-10">
                <div class="card bg-dark text-light border-primary border-opacity-25">
                    <div class="card-header bg-dark border-bottom border-primary border-opacity-25 py-3">
                        <h4 class="mb-0 text-primary">
                            <i class="bi bi-person-circle me-2"></i>Mi Perfil
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        @if (session('success'))
                            <div
                                class="alert alert-success bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <!-- Información del Usuario -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="bi bi-person-badge text-primary fs-5"></i>
                                </div>
                                <h5 class="text-primary mb-0">Información Personal</h5>
                            </div>

                            <div class="p-4 bg-black bg-opacity-25 border border-primary border-opacity-10 rounded-3">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="p-4 bg-dark rounded-3 border border-secondary border-opacity-25">
                                            <p class="text-primary small mb-1">Nombre</p>
                                            <p class="mb-0 fs-5 text-break">{{ auth()->user()->name }}</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="p-4 bg-dark rounded-3 border border-secondary border-opacity-25">
                                            <p class="text-primary small mb-1">Email</p>
                                            <p class="mb-0 fs-5 text-break">{{ auth()->user()->email }}</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="p-4 bg-dark rounded-3 border border-secondary border-opacity-25">
                                            <p class="text-primary small mb-1">Fecha de Nacimiento</p>
                                            <p class="mb-0 fs-5">
                                                {{ \Carbon\Carbon::parse(auth()->user()->birthday)->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-center">
                                            <div class="p-4 bg-dark rounded-3 border border-secondary border-opacity-25">
                                                <p class="text-primary small mb-1 text-center">Rol</p>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <span
                                                        class="badge bg-{{ auth()->user()->rol === 'admin' ? 'danger' : 'primary' }} bg-opacity-75 px-3 py-2 fs-6">
                                                        <i
                                                            class="bi bi-{{ auth()->user()->rol === 'admin' ? 'shield-lock' : 'person' }} me-2"></i>
                                                        {{ auth()->user()->rol === 'admin' ? 'Administrador' : 'Miembro' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Zona de Peligro -->
                        <div class="border-top border-danger border-opacity-25 pt-4 mt-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="bi bi-exclamation-triangle text-danger fs-5"></i>
                                </div>
                                <h5 class="text-danger mb-0">Zona de Peligro</h5>
                            </div>

                            <div class="p-4 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3">
                                <p class="text-light opacity-75 mb-4">
                                    Una vez eliminada tu cuenta, todos tus datos serán borrados permanentemente.
                                    Esta acción no se puede deshacer.
                                </p>
                                <button type="button" class="btn btn-danger btn-lg px-4" data-bs-toggle="modal"
                                    data-bs-target="#deleteAccountModal">
                                    <i class="bi bi-trash me-2"></i>Eliminar Cuenta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Mejorado -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light border border-danger border-opacity-25">
                <div class="modal-header border-danger border-opacity-25 py-3">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        Esta acción eliminará permanentemente tu cuenta y todos los datos asociados.
                    </div>
                </div>

                <div class="modal-footer border-danger border-opacity-25">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </button>
                    <form action="{{ route('account.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100"
                            onclick="return confirm('¿Estás seguro de eliminar esta cuenta?')">
                            <i class="bi bi-trash me-2"></i>Eliminar Cuenta
                        </button>
                    </form>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos base */
        .card {
            max-width: 1400px;
            margin: 0 auto;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .form-control {
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #1a1a1a;
            border-color: #0d6efd;
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .form-control:hover {
            border-color: #0d6efd;
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .alert {
            border-radius: 0.5rem;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }

        /* Estilos responsivos */
        @media (min-width: 992px) {
            .card {
                min-width: 800px;
            }

            .card-body {
                padding: 2rem;
            }
        }

        @media (max-width: 991px) {
            .fs-5 {
                font-size: 1rem !important;
            }

            .p-4 {
                padding: 1rem !important;
            }

            .card-body {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .fs-5 {
                font-size: 0.9rem !important;
            }

            .badge {
                font-size: 0.8rem !important;
            }

            .btn-lg {
                padding: 0.5rem 1rem;
                font-size: 1rem;
            }
        }

        /* Mejoras de accesibilidad */
        .text-break {
            word-break: break-word;
            overflow-wrap: break-word;
        }

        /* Animaciones */
        .card {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
