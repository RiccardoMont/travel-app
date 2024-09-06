<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\TripController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/maptest', function () {
        return Inertia::render('MapTest');
    })->name('maptest');

    //Laravel non supporta il caricamento delle immagini tramite il metodo put/patch e sfrutto quindi il metodo POST sulla rotta dell'update. La dichiaro prima in modo da privilegiare questa rotta e non quella creata con il resource.
    Route::post('trips/{trip}', [TripController::class, 'update']);

    Route::resource('trips', TripController::class);

    Route::resource('stops', StopController::class);

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    
});

require __DIR__.'/auth.php';
