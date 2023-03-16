<?php

use App\Http\Controllers\AssignedController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
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

    Route::group(['prefix' => 'categories'], function() {
        Route::get('/', [CategoryController::class, 'index'])
            ->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])
            ->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])
            ->name('categories.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])
            ->name('categories.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])
            ->name('categories.update');
        Route::post('/destroy{id}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');
    });

    Route::group(['prefix' => 'departments'], function() {
        Route::get('/', [DepartmentController::class, 'index'])
            ->name('departments.index');
        Route::get('/create', [DepartmentController::class, 'create'])
            ->name('departments.create');
        Route::post('/store', [DepartmentController::class, 'store'])
            ->name('departments.store');
        Route::get('/edit/{id}', [DepartmentController::class, 'edit'])
            ->name('departments.edit');
        Route::post('/update/{id}', [DepartmentController::class, 'update'])
            ->name('departments.update');
        Route::post('/destroy{id}', [DepartmentController::class, 'destroy'])
            ->name('departments.destroy');
    });

    Route::group(['prefix' => 'tickets'], function() {
        Route::get('/', [TicketController::class, 'index'])
            ->name('tickets.index');
        Route::get('/create', [TicketController::class, 'create'])
            ->name('tickets.create');
        Route::post('/store', [TicketController::class, 'store'])
            ->name('tickets.store');
        Route::get('/detail', [TicketController::class, 'detail'])
            ->name('tickets.detail');
        Route::get('/show/{code}', [TicketController::class, 'show'])
            ->name('tickets.show');
        Route::get('/edit/{code}', [TicketController::class, 'edit'])
            ->name('tickets.edit');
        Route::post('/update/{code}', [TicketController::class, 'update'])
            ->name('tickets.update');
        Route::post('/destroy/{code}', [TicketController::class, 'destroy'])
            ->name('tickets.destroy');
        Route::post('/status/update/{code}', [TicketController::class, 'statusUpdate'])
            ->name('tickets.status.update');

        Route::group(['prefix' => 'assigneds'], function() {
            Route::post('/update/{code}', [AssignedController::class, 'update'])
                ->name('assigneds.update');
        });
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [UserController::class, 'index'])
            ->name('users.index');
        Route::get('/create', [UserController::class, 'create'])
            ->name('users.create');
        Route::post('/store', [UserController::class, 'store'])
            ->name('users.store');
        Route::get('/detail', [UserController::class, 'detail'])
            ->name('users.detail');
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
