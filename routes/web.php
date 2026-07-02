<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoluntarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VoluntarioController::class, 'index'])->name('voluntarios.index');
Route::post('/buscar', [VoluntarioController::class, 'buscar'])->name('voluntarios.buscar');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/voluntarios', [VoluntarioController::class, 'listado'])->name('voluntarios.listado');
    Route::get('/admin/voluntarios/create', [VoluntarioController::class, 'create'])->name('voluntarios.create');
    Route::post('/admin/voluntarios', [VoluntarioController::class, 'store'])->name('voluntarios.store');
    Route::get('/admin/voluntarios/{voluntario}', [VoluntarioController::class, 'show'])->name('voluntarios.show');
    Route::get('/admin/voluntarios/{voluntario}/edit', [VoluntarioController::class, 'edit'])->name('voluntarios.edit');
    Route::put('/admin/voluntarios/{voluntario}', [VoluntarioController::class, 'update'])->name('voluntarios.update');
    Route::patch('/admin/voluntarios/{voluntario}/desactivar', [VoluntarioController::class, 'desactivar'])->name('voluntarios.desactivar');
    Route::delete('/admin/voluntarios/{voluntario}', [VoluntarioController::class, 'destroy'])->name('voluntarios.destroy');
});
