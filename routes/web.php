<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
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


Route::get('/',[UserController::class,'index'])
->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// Admin Routes
Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
    Route::get('/admin.logout', [AdminController::class, 'logout'])
        ->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'profile'])
        ->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'ProfileStore'])
        ->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'ChangePassword'])
        ->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, "passwordUpdate"])
        ->name('admin.password.update');
});
Route::get('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login');


// Instructor Routes
Route::middleware(['auth', 'roles:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'index'])
        ->name('instructor.dashboard');

        Route::get('/instructor/logout', [InstructorController::class, 'logout'])
        ->name('instructor.logout');
        
        Route::get('/instructor/profile', [InstructorController::class, 'profile'])
        ->name('instructor.profile');
    Route::post('/instructor/profile/store', [InstructorController::class, 'ProfileStore'])
        ->name('instructor.profile.store');

        Route::get('/instructor/change/password', [InstructorController::class, 'ChangePassword'])
        ->name('instructor.change.password');
    Route::post('/instructor/password/update', [InstructorController::class, "passwordUpdate"])
        ->name('instructor.password.update');  


});
Route::get('/instructor/login', [InstructorController::class, 'login'])
    ->name('instructor.login');


