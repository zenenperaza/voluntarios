<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoluntarioController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

$deployAuthorized = function (string $token): void {
    $deployToken = env('DEPLOY_TOKEN');

    abort_if(blank($deployToken), 404);
    abort_unless(hash_equals($deployToken, $token), 403);
};

$artisanResponse = function (array $lines) {
    return response('<pre>'.e(implode("\n\n", $lines)).'</pre>');
};

Route::prefix('__deploy/{token}')->group(function () use ($deployAuthorized, $artisanResponse): void {
    Route::get('/', function (string $token) use ($deployAuthorized, $artisanResponse) {
        $deployAuthorized($token);

        return $artisanResponse([
            'Panel temporal de despliegue',
            'Abrir estas rutas despues de subir el proyecto:',
            url("__deploy/{$token}/repair"),
            url("__deploy/{$token}/storage-link"),
            url("__deploy/{$token}/migrate"),
            url("__deploy/{$token}/seed-admin"),
            url("__deploy/{$token}/clear"),
            url("__deploy/{$token}/cache"),
            'Cuando termines, elimina DEPLOY_TOKEN del .env o borra estas rutas temporales.',
        ]);
    })->name('deploy.panel');

    Route::get('/repair', function (string $token) use ($deployAuthorized, $artisanResponse) {
        $deployAuthorized($token);

        $paths = [
            storage_path(),
            storage_path('app'),
            storage_path('app/public'),
            storage_path('framework'),
            storage_path('framework/cache'),
            storage_path('framework/cache/data'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
            base_path('bootstrap/cache'),
        ];

        $out = [];

        foreach ($paths as $path) {
            if (! file_exists($path)) {
                $out[] = @mkdir($path, 0775, true)
                    ? "Creada: {$path}"
                    : "No se pudo crear: {$path}";
            } else {
                $out[] = "Ya existe: {$path}";
            }

            if (file_exists($path)) {
                $out[] = @chmod($path, 0775)
                    ? "Permisos aplicados: {$path}"
                    : "No se pudieron cambiar permisos: {$path}";
            }
        }

        Artisan::call('optimize:clear');
        $out[] = 'optimize:clear ejecutado';
        $out[] = trim(Artisan::output());

        return $artisanResponse($out);
    });

    Route::get('/storage-link', function (string $token) use ($deployAuthorized, $artisanResponse) {
        $deployAuthorized($token);

        $out = [];
        $publicStorage = public_path('storage');

        if (is_link($publicStorage)) {
            $out[] = @unlink($publicStorage)
                ? "Symlink anterior eliminado: {$publicStorage}"
                : "No se pudo eliminar el symlink anterior: {$publicStorage}";
        } elseif (file_exists($publicStorage)) {
            $out[] = "public/storage existe pero no es symlink. No se elimino automaticamente.";
        }

        Artisan::call('storage:link');
        $out[] = 'storage:link ejecutado';
        $out[] = trim(Artisan::output());

        return $artisanResponse($out);
    });

    Route::get('/migrate', function (string $token) use ($deployAuthorized, $artisanResponse) {
        $deployAuthorized($token);

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        return $artisanResponse([
            'migrate ejecutado',
            trim(Artisan::output()),
        ]);
    });

    Route::get('/seed-admin', function (string $token) use ($deployAuthorized, $artisanResponse) {
        $deployAuthorized($token);

        Artisan::call('db:seed', [
            '--class' => 'DatabaseSeeder',
            '--force' => true,
        ]);

        return $artisanResponse([
            'db:seed ejecutado',
            trim(Artisan::output()),
        ]);
    });

    Route::get('/clear', function (string $token) use ($deployAuthorized, $artisanResponse) {
        $deployAuthorized($token);

        Artisan::call('optimize:clear');

        return $artisanResponse([
            'optimize:clear ejecutado',
            trim(Artisan::output()),
        ]);
    });

    Route::get('/cache', function (string $token) use ($deployAuthorized, $artisanResponse) {
        $deployAuthorized($token);

        $out = [];

        foreach (['config:cache', 'view:cache'] as $command) {
            Artisan::call($command);
            $out[] = "{$command} ejecutado";
            $out[] = trim(Artisan::output());
        }

        $out[] = 'route:cache omitido porque existen rutas temporales con closures.';
        $out[] = 'Cuando elimines estas rutas __deploy, podras ejecutar route:cache.';

        return $artisanResponse($out);
    });
});

Route::get('/', [VoluntarioController::class, 'index'])->name('voluntarios.index');
Route::post('/buscar', [VoluntarioController::class, 'buscar'])->name('voluntarios.buscar');
Route::get('/qr/{qrToken}', [VoluntarioController::class, 'perfilQr'])->name('voluntarios.qr');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/admin/voluntarios', [VoluntarioController::class, 'listado'])->name('voluntarios.listado');
    Route::get('/admin/voluntarios/create', [VoluntarioController::class, 'create'])->name('voluntarios.create');
    Route::post('/admin/voluntarios', [VoluntarioController::class, 'store'])->name('voluntarios.store');
    Route::get('/admin/voluntarios/{voluntario}', [VoluntarioController::class, 'show'])->name('voluntarios.show');
    Route::get('/admin/voluntarios/{voluntario}/edit', [VoluntarioController::class, 'edit'])->name('voluntarios.edit');
    Route::put('/admin/voluntarios/{voluntario}', [VoluntarioController::class, 'update'])->name('voluntarios.update');
    Route::patch('/admin/voluntarios/{voluntario}/desactivar', [VoluntarioController::class, 'desactivar'])->name('voluntarios.desactivar');
    Route::delete('/admin/voluntarios/{voluntario}', [VoluntarioController::class, 'destroy'])->name('voluntarios.destroy');
});
