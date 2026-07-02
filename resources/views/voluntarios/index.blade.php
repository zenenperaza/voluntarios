<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta de Voluntarios | ASONACOP</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        :root {
            --asonacop-primary: #354b86;
            --asonacop-primary-dark: #263865;
            --asonacop-accent: #00b894;
            --asonacop-soft: #f3f6fb;
        }

        body {
            min-height: 100vh;
            background: var(--asonacop-soft);
        }

        .public-shell {
            min-height: 100vh;
            padding: 32px 0;
        }

        .brand-logo {
            max-height: 52px;
            width: auto;
        }

        .search-card {
            border: 0;
            border-radius: 8px;
            box-shadow: 0 10px 28px rgba(50, 58, 70, 0.08);
        }

        .search-input {
            min-height: 46px;
        }

        .btn-consulta {
            min-height: 46px;
            background: var(--asonacop-primary);
            border-color: var(--asonacop-primary);
        }

        .btn-consulta:hover,
        .btn-consulta:focus {
            background: var(--asonacop-primary-dark);
            border-color: var(--asonacop-primary-dark);
        }

        .profile-card {
            overflow: hidden;
            border: 0;
            border-radius: 8px;
            box-shadow: 0 12px 32px rgba(50, 58, 70, 0.1);
        }

        .profile-cover {
            position: relative;
            min-height: 250px;
            display: flex;
            align-items: flex-end;
            padding: 32px;
            background:
                linear-gradient(90deg, rgba(38, 56, 101, 0.96), rgba(53, 75, 134, 0.78)),
                url("{{ asset('assets/images/users/profile.jpg') }}") center/cover;
        }

        .profile-cover::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(15, 23, 42, 0.18) 100%);
        }

        .profile-head {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 24px;
            width: 100%;
            color: #fff;
        }

        .profile-photo,
        .profile-initials {
            width: 132px;
            height: 132px;
            flex: 0 0 132px;
            border: 5px solid rgba(255, 255, 255, 0.92);
            border-radius: 50%;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.22);
        }

        .profile-photo {
            background: #fff;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .profile-initials {
            display: grid;
            place-items: center;
            background: #fff;
            color: var(--asonacop-primary);
            font-size: 42px;
            font-weight: 700;
        }

        .profile-title {
            min-width: 0;
        }

        .profile-title h1 {
            margin: 0 0 8px;
            color: #fff;
            font-size: clamp(28px, 4vw, 42px);
            letter-spacing: 0;
        }

        .profile-title p {
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 17px;
        }

        .profile-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 18px;
            color: rgba(255, 255, 255, 0.86);
        }

        .profile-meta span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .profile-body {
            padding: 28px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(0, 184, 148, 0.12);
            color: #00886c;
            font-weight: 600;
        }

        .info-card {
            height: 100%;
            border: 1px solid #edf0f5;
            border-radius: 8px;
            background: #fff;
            padding: 18px;
        }

        .info-card .icon {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(53, 75, 134, 0.1);
            color: var(--asonacop-primary);
            font-size: 18px;
        }

        .info-label {
            margin: 12px 0 4px;
            color: #98a6ad;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .info-value {
            margin: 0;
            color: #323a46;
            font-size: 16px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .empty-card {
            border: 0;
            border-radius: 8px;
            box-shadow: 0 10px 28px rgba(50, 58, 70, 0.08);
        }

        @media (max-width: 767.98px) {
            .public-shell {
                padding: 18px 0;
            }

            .profile-cover {
                min-height: 0;
                padding: 28px 20px;
            }

            .profile-head {
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
            }

            .profile-photo,
            .profile-initials {
                width: 106px;
                height: 106px;
                flex-basis: 106px;
            }

            .profile-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    @php
        $nombreCompleto = $voluntario ? trim($voluntario->nombre . ' ' . $voluntario->apellido) : '';
        $iniciales = $voluntario ? strtoupper(substr($voluntario->nombre, 0, 1) . substr($voluntario->apellido, 0, 1)) : '';
        $fotoUrl = $voluntario && $voluntario->foto ? Storage::url($voluntario->foto) : null;
    @endphp

    <main class="public-shell">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="{{ route('voluntarios.index') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                            <img class="brand-logo" src="{{ asset('assets/images/logos/asonacop.png') }}" alt="ASONACOP">
                            <span class="fw-semibold text-dark">Voluntarios</span>
                        </a>
                        <span class="badge bg-primary-subtle text-primary px-3 py-2">Consulta publica</span>
                    </div>

                    <div class="card search-card mb-4">
                        <div class="card-body p-3 p-md-4">
                            <form method="POST" action="{{ route('voluntarios.buscar') }}">
                                @csrf
                                <div class="row g-3 align-items-end">
                                    <div class="col-12 col-lg">
                                        <label for="cedula" class="form-label fw-semibold">Cedula del voluntario</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="mdi mdi-card-account-details-outline"></i>
                                            </span>
                                            <input
                                                id="cedula"
                                                name="cedula"
                                                type="text"
                                                class="form-control border-start-0 search-input"
                                                value="{{ old('cedula', $cedula ?? '') }}"
                                                placeholder="Ej: 12345678"
                                                maxlength="20"
                                                autocomplete="off"
                                                required
                                            >
                                        </div>
                                        @error('cedula')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-lg-auto">
                                        <button class="btn btn-primary btn-consulta w-100 px-4" type="submit">
                                            <i class="mdi mdi-magnify me-1"></i> Consultar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (($buscado ?? false) && ! $voluntario)
                        <div class="card empty-card">
                            <div class="card-body text-center p-4 p-md-5">
                                <div class="avatar-lg mx-auto mb-3">
                                    <div class="avatar-title bg-danger-subtle text-danger rounded-circle fs-2">
                                        <i class="mdi mdi-account-search-outline"></i>
                                    </div>
                                </div>
                                <h4 class="mb-2">Voluntario no encontrado</h4>
                                <p class="text-muted mb-0">
                                    No se encontro un voluntario activo con la cedula <strong>{{ $cedula }}</strong>.
                                </p>
                            </div>
                        </div>
                    @elseif ($voluntario)
                        <article class="card profile-card">
                            <div class="profile-cover">
                                <div class="profile-head">
                                    @if ($fotoUrl)
                                        <div
                                            class="profile-photo"
                                            style="background-image: url('{{ $fotoUrl }}');"
                                            role="img"
                                            aria-label="Foto de {{ $nombreCompleto }}"
                                        ></div>
                                    @else
                                        <div class="profile-initials" aria-label="Sin foto">{{ $iniciales }}</div>
                                    @endif

                                    <div class="profile-title">
                                        <h1>{{ $nombreCompleto }}</h1>
                                        <p>{{ $voluntario->cargo ?: 'Voluntario registrado' }}</p>
                                        <div class="profile-meta">
                                            <span><i class="mdi mdi-card-account-details-outline"></i> Cedula {{ $voluntario->cedula }}</span>
                                            <span><i class="mdi mdi-briefcase-outline"></i> {{ $voluntario->profesion ?: 'Profesion no registrada' }}</span>
                                            <span><i class="mdi mdi-map-marker-outline"></i> {{ $voluntario->ubicacion ?: 'Ubicacion no registrada' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-body">
                                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                                    <div>
                                        <span class="status-pill">
                                            <i class="mdi mdi-check-decagram-outline"></i>
                                            Voluntario activo
                                        </span>
                                    </div>
                                    <a href="{{ route('voluntarios.index') }}" class="btn btn-light">
                                        <i class="mdi mdi-refresh me-1"></i> Nueva consulta
                                    </a>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12 col-sm-6 col-xl-4">
                                        <div class="info-card">
                                            <span class="icon"><i class="mdi mdi-account-outline"></i></span>
                                            <div class="info-label">Nombre</div>
                                            <p class="info-value">{{ $voluntario->nombre }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-4">
                                        <div class="info-card">
                                            <span class="icon"><i class="mdi mdi-account-box-outline"></i></span>
                                            <div class="info-label">Apellido</div>
                                            <p class="info-value">{{ $voluntario->apellido }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-4">
                                        <div class="info-card">
                                            <span class="icon"><i class="mdi mdi-card-account-details-outline"></i></span>
                                            <div class="info-label">Cedula</div>
                                            <p class="info-value">{{ $voluntario->cedula }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-4">
                                        <div class="info-card">
                                            <span class="icon"><i class="mdi mdi-school-outline"></i></span>
                                            <div class="info-label">Profesion</div>
                                            <p class="info-value">{{ $voluntario->profesion ?: 'No registrada' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-4">
                                        <div class="info-card">
                                            <span class="icon"><i class="mdi mdi-briefcase-outline"></i></span>
                                            <div class="info-label">Cargo</div>
                                            <p class="info-value">{{ $voluntario->cargo ?: 'No registrado' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-xl-4">
                                        <div class="info-card">
                                            <span class="icon"><i class="mdi mdi-domain"></i></span>
                                            <div class="info-label">Organismo</div>
                                            <p class="info-value">{{ $voluntario->organismo ?: 'No registrado' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endif
                </div>
            </div>
        </div>
    </main>
</body>
</html>
