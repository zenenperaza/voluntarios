@extends('admin.layout')

@section('title', 'Ingresar Voluntario')

@section('content')
    <div class="page-title-box d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
        <div>
            <h4 class="mb-1">Ingresar voluntario</h4>
            <p class="text-muted mb-0">Registra los datos que luego podran consultarse por cedula.</p>
        </div>
        <a href="{{ route('voluntarios.listado') }}" class="btn btn-light">
            <i class="mdi mdi-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('voluntarios.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.voluntarios._form')

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('voluntarios.listado') }}" class="btn btn-light">Cancelar</a>
                    <button type="submit" class="btn btn-primary btn-admin">
                        <i class="mdi mdi-content-save-outline me-1"></i> Guardar voluntario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
