@extends('admin.layout')

@section('title', 'Editar Voluntario')

@section('content')
    <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h4 class="mb-1">Editar voluntario</h4>
            <p class="text-muted mb-0">{{ $voluntario->nombre }} {{ $voluntario->apellido }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('voluntarios.show', $voluntario) }}" class="btn btn-light">
                <i class="mdi mdi-eye-outline me-1"></i> Ver perfil
            </a>
            <a href="{{ route('voluntarios.listado') }}" class="btn btn-light">
                <i class="mdi mdi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('voluntarios.update', $voluntario) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.voluntarios._form', ['voluntario' => $voluntario])

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('voluntarios.listado') }}" class="btn btn-light">Cancelar</a>
                    <button type="submit" class="btn btn-primary btn-admin">
                        <i class="mdi mdi-content-save-outline me-1"></i> Actualizar voluntario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
