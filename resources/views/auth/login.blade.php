<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso al Sistema | ASONACOP</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        :root {
            --login-primary: #354b86;
            --login-primary-dark: #263865;
            --login-soft: #f3f6fb;
        }

        body {
            min-height: 100vh;
            background:
                linear-gradient(120deg, rgba(38, 56, 101, 0.95), rgba(53, 75, 134, 0.78)),
                url("{{ asset('assets/images/users/profile.jpg') }}") center/cover fixed;
        }

        .login-shell {
            min-height: 100vh;
            display: grid;
            align-items: center;
            padding: 28px 0;
        }

        .login-card {
            border: 0;
            border-radius: 8px;
            box-shadow: 0 18px 48px rgba(15, 23, 42, 0.28);
        }

        .brand-logo {
            max-height: 58px;
            width: auto;
        }

        .btn-login {
            min-height: 46px;
            background: var(--login-primary);
            border-color: var(--login-primary);
        }

        .btn-login:hover,
        .btn-login:focus {
            background: var(--login-primary-dark);
            border-color: var(--login-primary-dark);
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                    <div class="card login-card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <img class="brand-logo mb-3" src="{{ asset('assets/images/logos/asonacop.png') }}" alt="ASONACOP">
                                <h4 class="mb-1">Ingreso al sistema</h4>
                                <p class="text-muted mb-0">Acceso administrativo de voluntarios</p>
                            </div>

                            <form method="POST" action="{{ route('login.store') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="mdi mdi-email-outline"></i>
                                        </span>
                                        <input
                                            id="email"
                                            name="email"
                                            type="email"
                                            class="form-control border-start-0 @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}"
                                            placeholder="admin@example.com"
                                            autocomplete="email"
                                            autofocus
                                            required
                                        >
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Clave</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="mdi mdi-lock-outline"></i>
                                        </span>
                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            class="form-control border-start-0 @error('password') is-invalid @enderror"
                                            placeholder="Ingrese su clave"
                                            autocomplete="current-password"
                                            required
                                        >
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input id="remember" name="remember" type="checkbox" class="form-check-input" value="1">
                                        <label class="form-check-label" for="remember">Recordarme</label>
                                    </div>
                                    <a href="{{ route('voluntarios.index') }}" class="text-muted">Consulta publica</a>
                                </div>

                                <button type="submit" class="btn btn-primary btn-login w-100">
                                    <i class="mdi mdi-login me-1"></i> Ingresar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
