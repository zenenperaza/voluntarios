@php
    $voluntario = $voluntario ?? null;
@endphp

<div class="row g-3">
    <div class="col-12">
        <div class="form-section-title">Datos personales</div>
    </div>

    <div class="col-12 col-md-6">
        <label for="nombre" class="form-label">Nombre</label>
        <input id="nombre" name="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $voluntario->nombre ?? '') }}" maxlength="100" required>
        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="apellido" class="form-label">Apellido</label>
        <input id="apellido" name="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido', $voluntario->apellido ?? '') }}" maxlength="100" required>
        @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label for="cedula" class="form-label">Cedula</label>
        <input id="cedula" name="cedula" type="text" class="form-control @error('cedula') is-invalid @enderror" value="{{ old('cedula', $voluntario->cedula ?? '') }}" maxlength="20" required>
        @error('cedula')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label for="telefono" class="form-label">Telefono</label>
        <input id="telefono" name="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $voluntario->telefono ?? '') }}" maxlength="30">
        @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-4">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $voluntario->email ?? '') }}" maxlength="150">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <hr>
        <div class="form-section-title">Perfil del voluntario</div>
    </div>

    <div class="col-12 col-md-6">
        <label for="profesion" class="form-label">Profesion</label>
        <input id="profesion" name="profesion" type="text" class="form-control @error('profesion') is-invalid @enderror" value="{{ old('profesion', $voluntario->profesion ?? '') }}" maxlength="150">
        @error('profesion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="cargo" class="form-label">Cargo</label>
        <input id="cargo" name="cargo" type="text" class="form-control @error('cargo') is-invalid @enderror" value="{{ old('cargo', $voluntario->cargo ?? '') }}" maxlength="150">
        @error('cargo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="ubicacion" class="form-label">Ubicacion</label>
        <input id="ubicacion" name="ubicacion" type="text" class="form-control @error('ubicacion') is-invalid @enderror" value="{{ old('ubicacion', $voluntario->ubicacion ?? '') }}" maxlength="200">
        @error('ubicacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="organismo" class="form-label">Organismo</label>
        <input id="organismo" name="organismo" type="text" class="form-control @error('organismo') is-invalid @enderror" value="{{ old('organismo', $voluntario->organismo ?? '') }}" maxlength="200">
        @error('organismo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="estatus" class="form-label">Estatus</label>
        <select id="estatus" name="estatus" class="form-select @error('estatus') is-invalid @enderror" required>
            @foreach (['Activo', 'Inactivo'] as $estatus)
                <option value="{{ $estatus }}" @selected(old('estatus', $voluntario->estatus ?? 'Activo') === $estatus)>{{ $estatus }}</option>
            @endforeach
        </select>
        @error('estatus')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="foto" class="form-label">Foto</label>
        <input id="foto" name="foto" type="file" class="form-control @error('foto') is-invalid @enderror" accept="image/png,image/jpeg,image/webp">
        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @if ($voluntario && $voluntario->foto)
            <div class="form-text">Foto actual: {{ $voluntario->foto }}</div>
        @endif
    </div>

    <div class="col-12">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea id="observaciones" name="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="4">{{ old('observaciones', $voluntario->observaciones ?? '') }}</textarea>
        @error('observaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
