<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::view('/', 'dashboard')->name('dashboard');

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [UserController::class, 'index'])
            ->name('users.index');
        Route::get('/create', [UserController::class, 'create'])
            ->name('users.create');
        Route::post('/store', [UserController::class, 'store'])
            ->name('users.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])
            ->name('users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])
            ->name('users.update');
        Route::post('/destroy{id}', [UserController::class, 'destroy'])
            ->name('users.destroy');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
