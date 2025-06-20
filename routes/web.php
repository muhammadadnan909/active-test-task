<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


// Admin auth routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Route::middleware(['auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    //     // Route::get('dashboard', fn() => view('admin.index'))->name('dashboard');
    //     Route::get('home', [HomeController::class, 'index'])->name('home');

    // });
    Route::middleware(['auth:admin'])->name('admin.')->group(function () {
        Route::get('home', [HomeController::class, 'index'])->name('home');
    });
});





Route::middleware(['auth:user'])->group(function () {
    Route::get('user/home', [HomeController::class, 'index'])->name('home');
    Route::delete('/posts/{type}/{id}', [HomeController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{type}/{id}/edit', [HomeController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{type}/{id}', [HomeController::class, 'update'])->name('posts.update');
    Route::get('/posts/create/{type}', [HomeController::class, 'create'])->name('posts.create');
    Route::post('/posts', [HomeController::class, 'store'])->name('posts.store');
});



