<?php

use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
use App\Http\Controllers\admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public routes
// Route::get('auth/login', [AuthController::class, 'login'])->name('login');
Route::middleware('guest')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('auth/login', [AuthController::class, 'loginIndex'])->name('login.view');
});
// Protected routes
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::post('auth/me', [AuthController::class, 'me']);
});
Route::prefix('admin')->group(function () {
    Route::middleware('logged_user')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/user', [AdminUserController::class, 'index'])->name('admin.user.view');
        Route::get('/product', [AdminProductController::class, 'index'])->name('admin.product.view');
        Route::post('/product', [AdminProductController::class, 'create'])->name('admin.product.create');
        Route::post('/product/update', [AdminProductController::class, 'update'])->name('admin.product.update');
        Route::post('/product/delete/{id}', [AdminProductController::class, 'delete'])->name('admin.product.delete');
    });
});
