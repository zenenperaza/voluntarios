@extends('admin.layout')

@section('title', 'Listado de Voluntarios')

@section('content')
    <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h4 class="mb-1">Listado de voluntarios</h4>
            <p class="text-muted mb-0">Gestiona registros, estatus y perfiles completos.</p>
        </div>
        <a href="{{ route('voluntarios.create') }}" class="btn btn-primary btn-admin">
            <i class="mdi mdi-account-plus-outline me-1"></i> Ingresar voluntario
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-centered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Voluntario</th>
                            <th>Cedula</th>
                            <th>Profesion</th>
                            <th>Cargo</th>
                            <th>Estatus</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($voluntarios as $voluntario)
                            @php
                                $nombreCompleto = trim($voluntario->nombre . ' ' . $voluntario->apellido);
                                $iniciales = strtoupper(substr($voluntario->nombre, 0, 1) . substr($voluntario->apellido, 0, 1));
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($voluntario->foto)
                                            <img class="avatar-list" src="{{ Storage::url($voluntario->foto) }}" alt="Foto de {{ $nombreCompleto }}">
                                        @else
                                            <span class="avatar-list avatar-initials">{{ $iniciales }}</span>
                                        @endif
                                        <div>
                                            <h5 class="font-14 mb-1">{{ $nombreCompleto }}</h5>
                                            <span class="text-muted">{{ $voluntario->email ?: 'Sin email' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $voluntario->cedula }}</td>
                                <td>{{ $voluntario->profesion ?: 'No registrada' }}</td>
                                <td>{{ $voluntario->cargo ?: 'No registrado' }}</td>
                                <td>
                                    @if ($voluntario->estatus === 'Activo')
                                        <span class="badge bg-success-subtle text-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('voluntarios.show', $voluntario) }}" class="btn btn-sm btn-soft-primary" title="Ver perfil">
                                            <i class="mdi mdi-eye-outline"></i>
                                        </a>
                                        <a href="{{ route('voluntarios.edit', $voluntario) }}" class="btn btn-sm btn-soft-warning" title="Editar">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                        @if ($voluntario->estatus === 'Activo')
                                            <form method="POST" action="{{ route('voluntarios.desactivar', $voluntario) }}" onsubmit="return confirm('Deseas desactivar este voluntario?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-soft-danger" title="Desactivar">
                                                    <i class="mdi mdi-account-off-outline"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="avatar-lg mx-auto mb-3">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-2">
                                            <i class="mdi mdi-account-group-outline"></i>
                                        </div>
                                    </div>
                                    <h5>No hay voluntarios registrados</h5>
                                    <a href="{{ route('voluntarios.create') }}" class="btn btn-primary btn-admin mt-2">Ingresar voluntario</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($voluntarios->hasPages())
                <div class="mt-3">
                    {{ $voluntarios->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
