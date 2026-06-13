<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CerdaController;
use App\Http\Controllers\InseminacionController;
use App\Http\Controllers\PartoController;
use App\Http\Controllers\QuickRecordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Cerdas
    Route::resource('cerdas', CerdaController::class);

    // CRUD Inseminaciones
    Route::get('inseminaciones', [InseminacionController::class, 'index'])->name('inseminaciones.index');
    Route::get('inseminaciones/crear', [InseminacionController::class, 'create'])->name('inseminaciones.create');
    Route::post('inseminaciones', [InseminacionController::class, 'store'])->name('inseminaciones.store');
    Route::post('inseminaciones/{inseminacion}/confirmar', [InseminacionController::class, 'confirm'])->name('inseminaciones.confirm');

    // CRUD Partos
    Route::get('partos', [PartoController::class, 'index'])->name('partos.index');
    Route::get('partos/crear', [PartoController::class, 'create'])->name('partos.create');
    Route::post('partos', [PartoController::class, 'store'])->name('partos.store');

    // Quick Records (Alimentación, Vacunas, Tratamientos, Destete)
    Route::post('quick-record/alimento', [QuickRecordController::class, 'storeAlimento'])->name('quick-record.alimento');
    Route::post('quick-record/vacunacion', [QuickRecordController::class, 'storeVacunacion'])->name('quick-record.vacunacion');
    Route::post('quick-record/tratamiento', [QuickRecordController::class, 'storeTratamiento'])->name('quick-record.tratamiento');
    Route::post('quick-record/destete', [QuickRecordController::class, 'storeDestete'])->name('quick-record.destete');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestión de usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
});

require __DIR__.'/auth.php';
