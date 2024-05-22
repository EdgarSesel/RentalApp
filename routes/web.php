<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');

Route::get('/index', [HomeController::class, 'index'])->name('index');

Route::get('/profile', [UserController::class, 'profile'])->name('profile');
// routes/web.php

Route::put('/profile', [UserController::class, 'update'])->name('profile.update')->middleware('auth');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('auth');
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('auth');
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('auth');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/products/{product}/rent', [ProductController::class, 'rent'])->name('products.rent')->middleware('auth');
Route::post('/rents', [RentController::class, 'store'])->name('rents.store')->middleware('auth');
Route::get('/rents', [RentController::class, 'show'])->name('rents.show')->middleware('auth');
Route::post('/handle-payment', [PaymentController::class, 'handlePayment'])->name('payment.handle');
Route::get('/my-products', [ProductController::class, 'myProducts'])->name('products.my')->middleware('auth');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('auth');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('auth');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('auth');
Route::get('user-management', [UserController::class, 'management'])->name('user.management')->middleware('auth');
Route::get('product-management', [ProductController::class, 'manage'])->name('product.management')->middleware('auth');
Route::post('/user/{id}/ban', [UserController::class, 'ban'])->name('user.ban')->middleware('auth');
Route::get('/user/{id}/products', [UserController::class, 'check_products'])->name('user.products')->middleware('auth');
Route::post('/user/{id}/unban', [UserController::class, 'unban'])->name('user.unban');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
