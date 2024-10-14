<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TranzactiiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatesController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/actiuni', [App\Http\Controllers\ActiuniController::class, 'index'])->name('actiuni');

Route::get('/acasa', function () {
    return view('acasa');
})->middleware(['auth'])->name('acasa');

Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

// Ruta pentru pagina de profil
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

// Ruta pentru actualizarea profilului
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/cumparare', [TranzactiiController::class, 'cumparare'])->name('cumparare');
Route::post('/tranzactii/buy', [TranzactiiController::class, 'buy'])->name('tranzactii.buy');
Route::post('/tranzactii/sell', [TranzactiiController::class, 'sell'])->name('tranzactii.sell');
Route::post('/tranzactii/buysell', [TranzactiiController::class, 'buysell'])->name('tranzactii.buysell');

Route::get('/vanzare', [TranzactiiController::class, 'vanzare'])->name('vanzare');
Route::get('/cumpararevanzare', [TranzactiiController::class, 'cumpararevanzare'])->name('cumpararevanzare');

// Ruta pentru pagina de administrare
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth', 'admin');

// Rute pentru gestionarea utilizatorilor
Route::get('/admin/utilizatori', [UserController::class, 'index'])->name('utilizatori.index')->middleware('auth', 'admin');
Route::get('/admin/utilizatori/{id}/edit', [UserController::class, 'edit'])->name('utilizatori.edit')->middleware('auth', 'admin');
Route::put('/admin/utilizatori/{id}', [UserController::class, 'update'])->name('utilizatori.update')->middleware('auth', 'admin');
Route::post('/admin/utilizatori', [UserController::class, 'store'])->name('utilizatori.store');
Route::delete('/admin/utilizatori/{id}', [UserController::class, 'destroy'])->name('utilizatori.destroy');

// Rute pentru gestionarea ratelor de schimb
Route::prefix('admin/rates')->group(function () {
    Route::get('/', [RatesController::class, 'index'])->name('rates.index');
    Route::post('/', [RatesController::class, 'store'])->name('rates.store');
    Route::put('/{id}', [RatesController::class, 'update'])->name('rates.update');
    Route::delete('/{id}', [RatesController::class, 'destroy'])->name('rates.destroy');
});

require __DIR__.'/auth.php';
