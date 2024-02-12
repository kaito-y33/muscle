<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\AdminController as ControllersAdminController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrainingsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/Exercise', [ExerciseController::class, 'index'])->name('exercise.index');
    Route::get('/Exercise/Create', [ExerciseController::class, 'create'])->name('exercise.create');
    Route::post('/Exercise/Create', [ExerciseController::class, 'store']);
    Route::get('/Exercise/{date}/Edit', [ExerciseController::class, 'edit'])->name('exercise.edit');
    Route::post('/Exercise/{date}/Edit', [ExerciseController::class, 'update'])->name('exercise.update');
    Route::post('/Exercise/{exercise}/destroy', [ExerciseController::class, 'destroy'])->name('exercise.destroy');

    Route::get('/Exercise/Ajax', [ExerciseController::class, 'getAddDisplayExercises'])->name('exercise.ajax');
    Route::get('/fetch-graph-data', [HomeController::class, 'GetChartDataAjax'])->name('home.ajax');
    Route::get('/logout', function () {
        return redirect('/login');
    })->name('logout');
});

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/admin/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/admin/users/{user}/edit', [UsersController::class, 'showEditForm'])->name('users.edit');
    Route::put('/admin/users/{user}/edit', [UsersController::class, 'edit']);
    Route::post('/admin/users/{user}/destroy', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::get('/admin/trainings', [TrainingsController::class, 'index'])->name('trainings.index');
    Route::get('/admin/trainings/create', [TrainingsController::class, 'create'])->name('trainings.create');
    Route::post('/admin/trainings/create', [TrainingsController::class, 'store']);
    Route::get('/admin/trainings/{training}/edit', [TrainingsController::class, 'edit'])->name('trainings.edit');
    Route::put('/admin/trainings/{training}/edit', [TrainingsController::class, 'update']);
    Route::post('/admin/trainings/{training}/destroy', [TrainingsController::class, 'destroy'])->name('trainings.destroy');
});

Auth::routes();
