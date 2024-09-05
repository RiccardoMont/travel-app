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

/*Route::get('/statuses', function () {
    return Inertia::render('Statuses/index');
})->name('statuses');*/

//Route::resource('statuses', StatusController::class);



Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/maptest', function () {
        return Inertia::render('MapTest');
    })->name('maptest');

    /*Route::get('/statuses', function () {
        return Inertia::render('Statuses/index');
    })->name('statuses');*/

    /*Route::get('/trips', function() {
        return Inertia::render('Trips/index');
    })->name('trips');*/

    Route::resource('trips', TripController::class);

    Route::resource('stops', StopController::class);

    /*Route::get('/trips', [TripController::class, 'index'])->name('trips.index');

    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');*/



    /*Route::get('/stops', function() {
        return Inertia::render('Stops/index');
    })->name('stops');*/

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    
});

require __DIR__.'/auth.php';
