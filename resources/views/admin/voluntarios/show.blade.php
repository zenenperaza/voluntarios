@extends('admin.layout')

@section('title', 'Perfil Completo')

@section('content')
    @php
        $nombreCompleto = trim($voluntario->nombre . ' ' . $voluntario->apellido);
        $iniciales = strtoupper(substr($voluntario->nombre, 0, 1) . substr($voluntario->apellido, 0, 1));
        $qrUrl = route('voluntarios.qr', $voluntario->qr_token);
        $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=12&data=' . urlencode($qrUrl);
    @endphp

    <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h4 class="mb-1">Perfil completo</h4>
            <p class="text-muted mb-0">Vista administrativa del voluntario.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('voluntarios.edit', $voluntario) }}" class="btn btn-warning">
                <i class="mdi mdi-pencil-outline me-1"></i> Editar
            </a>
            @if ($voluntario->estatus === 'Activo')
                <form method="POST" action="{{ route('voluntarios.desactivar', $voluntario) }}" onsubmit="return confirm('Deseas desactivar este voluntario?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">
                        <i class="mdi mdi-account-off-outline me-1"></i> Desactivar
                    </button>
                </form>
            @endif
            <a href="{{ route('voluntarios.listado') }}" class="btn btn-light">
                <i class="mdi mdi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="profile-cover">
            <div class="d-flex flex-column flex-md-row align-items-md-end gap-3">
                @if ($voluntario->foto)
                    <img class="avatar-profile" src="{{ Storage::url($voluntario->foto) }}" alt="Foto de {{ $nombreCompleto }}">
                @else
                    <span class="avatar-profile avatar-initials fs-1 bg-white">{{ $iniciales }}</span>
                @endif
                <div>
                    <h1 class="mb-2">{{ $nombreCompleto }}</h1>
                    <p class="mb-2">{{ $voluntario->cargo ?: 'Cargo no registrado' }}</p>
                    @if ($voluntario->estatus === 'Activo')
                        <span class="badge bg-success px-3 py-2">Activo</span>
                    @else
                        <span class="badge bg-secondary px-3 py-2">Inactivo</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-lg-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-body">
                            <h5 class="mb-3">Contacto</h5>
                            <p class="mb-2"><i class="mdi mdi-card-account-details-outline text-primary me-2"></i><strong>Cedula:</strong> {{ $voluntario->cedula }}</p>
                            <p class="mb-2"><i class="mdi mdi-phone-outline text-primary me-2"></i><strong>Telefono:</strong> {{ $voluntario->telefono ?: 'No registrado' }}</p>
                            <p class="mb-0"><i class="mdi mdi-email-outline text-primary me-2"></i><strong>Email:</strong> {{ $voluntario->email ?: 'No registrado' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-body">
                            <h5 class="mb-3">Informacion profesional</h5>
                            <p class="mb-2"><i class="mdi mdi-school-outline text-primary me-2"></i><strong>Profesion:</strong> {{ $voluntario->profesion ?: 'No registrada' }}</p>
                            <p class="mb-2"><i class="mdi mdi-briefcase-outline text-primary me-2"></i><strong>Cargo:</strong> {{ $voluntario->cargo ?: 'No registrado' }}</p>
                            <p class="mb-0"><i class="mdi mdi-domain text-primary me-2"></i><strong>Organismo:</strong> {{ $voluntario->organismo ?: 'No registrado' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-body">
                            <h5 class="mb-3">Codigo QR</h5>
                            <div class="text-center">
                                <img src="{{ $qrImageUrl }}" alt="Codigo QR de {{ $nombreCompleto }}" class="img-fluid border rounded p-2 bg-white" width="220" height="220">
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <a href="{{ $qrUrl }}" target="_blank" rel="noopener" class="btn btn-soft-primary">
                                    <i class="mdi mdi-open-in-new me-1"></i> Abrir perfil publico
                                </a>
                                <a href="{{ $qrImageUrl }}" target="_blank" rel="noopener" class="btn btn-soft-success">
                                    <i class="mdi mdi-download-outline me-1"></i> Descargar QR
                                </a>
                            </div>
                            <p class="text-muted small mt-3 mb-0">{{ $qrUrl }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card shadow-none border h-100">
                        <div class="card-body">
                            <h5 class="mb-3">Registro</h5>
                            <p class="mb-2"><i class="mdi mdi-map-marker-outline text-primary me-2"></i><strong>Ubicacion:</strong> {{ $voluntario->ubicacion ?: 'No registrada' }}</p>
                            <p class="mb-2"><i class="mdi mdi-calendar-plus-outline text-primary me-2"></i><strong>Creado:</strong> {{ $voluntario->created_at?->format('d/m/Y H:i') ?: 'No disponible' }}</p>
                            <p class="mb-0"><i class="mdi mdi-calendar-edit-outline text-primary me-2"></i><strong>Actualizado:</strong> {{ $voluntario->updated_at?->format('d/m/Y H:i') ?: 'No disponible' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-none border mb-0">
                        <div class="card-body">
                            <h5 class="mb-3">Observaciones</h5>
                            <p class="mb-0 text-muted">{{ $voluntario->observaciones ?: 'Sin observaciones registradas.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
