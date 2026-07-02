<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Voluntarios') | ASONACOP</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        :root {
            --admin-primary: #354b86;
            --admin-primary-dark: #263865;
            --admin-soft: #f3f6fb;
        }

        body {
            min-height: 100vh;
            background: var(--admin-soft);
        }

        .admin-topbar {
            background: #fff;
            border-bottom: 1px solid #edf0f5;
            box-shadow: 0 3px 18px rgba(50, 58, 70, 0.06);
        }

        .brand-logo {
            max-height: 46px;
            width: auto;
        }

        .admin-main {
            padding: 28px 0;
        }

        .page-title-box {
            margin-bottom: 20px;
        }

        .btn-admin {
            background: var(--admin-primary);
            border-color: var(--admin-primary);
        }

        .btn-admin:hover,
        .btn-admin:focus {
            background: var(--admin-primary-dark);
            border-color: var(--admin-primary-dark);
        }

        .card {
            border: 0;
            border-radius: 8px;
            box-shadow: 0 10px 28px rgba(50, 58, 70, 0.08);
        }

        .avatar-list,
        .avatar-profile {
            object-fit: cover;
            background: #eef2f7;
        }

        .avatar-list {
            width: 44px;
            height: 44px;
            border-radius: 50%;
        }

        .avatar-profile {
            width: 132px;
            height: 132px;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 12px 28px rgba(50, 58, 70, 0.18);
        }

        .avatar-initials {
            display: inline-grid;
            place-items: center;
            color: var(--admin-primary);
            font-weight: 700;
        }

        .profile-cover {
            min-height: 220px;
            display: flex;
            align-items: flex-end;
            padding: 28px;
            border-radius: 8px 8px 0 0;
            background:
                linear-gradient(90deg, rgba(38, 56, 101, 0.96), rgba(53, 75, 134, 0.78)),
                url("{{ asset('assets/images/users/profile.jpg') }}") center/cover;
            color: #fff;
        }

        .profile-cover h1,
        .profile-cover p {
            color: #fff;
        }

        .table-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            justify-content: flex-end;
        }

        .form-section-title {
            font-size: 15px;
            font-weight: 700;
            color: #323a46;
            margin-bottom: 14px;
        }

        @media (max-width: 767.98px) {
            .admin-main {
                padding: 18px 0;
            }

            .table-actions {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <header class="admin-topbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between py-3">
                <a href="{{ route('voluntarios.listado') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                    <img class="brand-logo" src="{{ asset('assets/images/logos/asonacop.png') }}" alt="ASONACOP">
                    <span class="fw-semibold text-dark">Admin Voluntarios</span>
                </a>
                <div class="d-flex align-items-center gap-2">
                    <span class="d-none d-md-inline text-muted">
                        {{ auth()->user()->name }}
                    </span>
                    <a href="{{ route('voluntarios.index') }}" class="btn btn-light">
                        <i class="mdi mdi-magnify me-1"></i> Consulta
                    </a>
                    <a href="{{ route('voluntarios.create') }}" class="btn btn-primary btn-admin">
                        <i class="mdi mdi-account-plus-outline me-1"></i> Nuevo
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-soft-danger">
                            <i class="mdi mdi-logout me-1"></i> Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="admin-main">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
