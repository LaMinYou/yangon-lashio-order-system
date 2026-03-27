<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FactController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SourceAreaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('userole'));

Route::get('/role', fn () => view('userole'));

Route::post('/role', function () {
    return request()->role == 1
        ? redirect()->route('user.login')
        : redirect()->route('admin.login');
})->name('role');

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Default)
|--------------------------------------------------------------------------
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| Custom Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/user/login', [LoginController::class, 'userLoginForm'])->name('user.login');
    Route::get('/admin/login', [LoginController::class, 'adminLoginForm'])->name('admin.login');
    Route::get('/user/register', [RegisterController::class, 'registerForm'])->name('user.register');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/orders/create', [OrderController::class, 'orderForm'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'create'])->name('orders.store');

    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::post('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');

    Route::get('/user/{id}/orders', [OrderController::class, 'show'])->name('orders.user');

    Route::post('/export', [OrderController::class, 'exporting'])->name('orders.export');

    /*
    |--------------------------------------------------------------------------
    | Facts
    |--------------------------------------------------------------------------
    */

    Route::get('/facts/add', [FactController::class, 'showFactForms']);
    Route::post('/facts/{id}', [FactController::class, 'edit'])->name('facts.update');
    Route::delete('/facts/{id}', [FactController::class, 'delete'])->name('facts.delete');

    /*
    |--------------------------------------------------------------------------
    | Master Data
    |--------------------------------------------------------------------------
    */

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/sourceareas', [SourceAreaController::class, 'index'])->name('sourceareas.index');
    Route::post('/sourceareas', [SourceAreaController::class, 'store'])->name('sourceareas.store');

    Route::get('/gates', [GateController::class, 'index'])->name('gates.index');
    Route::post('/gates', [GateController::class, 'store'])->name('gates.store');

    Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
    Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');

    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');

    /*
    |--------------------------------------------------------------------------
    | User Settings (FIXED ✅)
    |--------------------------------------------------------------------------
    */

    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])
        ->name('user.password.form');

    Route::post('/change-password', [UserController::class, 'changePassword'])
        ->name('user.password.update');

    Route::get('/forgot-password', [UserController::class, 'showForgotPasswordForm'])
        ->name('user.forgot-password');

    Route::post('/forgot-password', [UserController::class, 'forgotPassword']);

    Route::get('/reset-password', [UserController::class, 'showResetPasswordForm'])
        ->name('user.reset-password.form');

    Route::post('/reset-password', [UserController::class, 'resetPassword'])
        ->name('user.reset-password');

});
