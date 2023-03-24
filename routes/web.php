<?php

use App\Http\Controllers\AssignedController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [DashboardController::class, 'search'])->name('search');

    Route::group(['prefix' => 'categories'], function() {
        Route::get('/', [CategoryController::class, 'index'])
            ->name('categories.index')
            ->middleware('permission:category-list');
        Route::get('/create', [CategoryController::class, 'create'])
            ->name('categories.create')
            ->middleware('permission:category-create');
        Route::post('/store', [CategoryController::class, 'store'])
            ->name('categories.store')
            ->middleware('permission:category-create');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])
            ->name('categories.edit')
            ->middleware('permission:category-edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])
            ->name('categories.update')
            ->middleware('permission:category-edit');
        Route::post('/destroy{id}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy')
            ->middleware('permission:category-delete');
    });

    Route::group(['prefix' => 'departments'], function() {
        Route::get('/', [DepartmentController::class, 'index'])
            ->name('departments.index')
            ->middleware('permission:department-list');
        Route::get('/create', [DepartmentController::class, 'create'])
            ->name('departments.create')
            ->middleware('permission:department-create');
        Route::post('/store', [DepartmentController::class, 'store'])
            ->name('departments.store')
            ->middleware('permission:department-create');
        Route::get('/edit/{id}', [DepartmentController::class, 'edit'])
            ->name('departments.edit')
            ->middleware('permission:department-edit');
        Route::post('/update/{id}', [DepartmentController::class, 'update'])
            ->name('departments.update')
            ->middleware('permission:department-edit');
        Route::post('/destroy{id}', [DepartmentController::class, 'destroy'])
            ->name('departments.destroy')
            ->middleware('permission:department-delete');
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

    Route::group(['prefix' => 'roles'], function() {
        Route::get('/', [RoleController::class, 'index'])
            ->name('roles.index')
            ->middleware('permission:role-list');
        Route::get('/show/{id}', [RoleController::class, 'show'])
            ->name('roles.show')
            ->middleware('permission:role-detail');
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', [UserController::class, 'index'])
            ->name('users.index')
            ->middleware('permission:user-list');
        Route::get('/create', [UserController::class, 'create'])
            ->name('users.create')
            ->middleware('permission:user-create');
        Route::post('/store', [UserController::class, 'store'])
            ->name('users.store')
            ->middleware('permission:user-create');
        Route::get('/detail', [UserController::class, 'detail'])
            ->name('users.detail');
        Route::get('/show/{id}', [UserController::class, 'show'])
            ->name('users.show')
            ->middleware('permission:user-detail');
        Route::get('/edit/{id}', [UserController::class, 'edit'])
            ->name('users.edit')
            ->middleware('permission:user-edit');
        Route::post('/update/{id}', [UserController::class, 'update'])
            ->name('users.update')
            ->middleware('permission:user-edit');
        Route::post('/destroy{id}', [UserController::class, 'destroy'])
            ->name('users.destroy')
            ->middleware('permission:user-delete');

        Route::post('permissions/update/{id}', [UserController::class, 'permissionsUpdate'])
            ->name('users.permissions.update')
            ->middleware('permission:user-edit');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
