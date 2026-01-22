<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserSide\HomeController;
use App\Http\Controllers\UserSide\ProductController;
use App\Http\Controllers\UserSide\ContactController;



/*
|--------------------------------------------------------------------------
| User Side Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Categories & Products
Route::get('/categories', [ProductController::class, 'categories'])->name('categories');
Route::get('/category/{id}', [ProductController::class, 'productsByCategory'])->name('category.products');
Route::get('/product/{id}', [ProductController::class, 'productDetail'])->name('product.detail');

// Contact Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/category/{id}', [ProductController::class, 'productsByCategory'])
     ->name('category.products');


     // Categories & Products Pages
Route::get('/categories', function () {
    return view('categories');
})->name('categories');

Route::get('/category/{id}/products', function ($id) {
    return view('products', ['id' => $id]);
})->name('products.by.category');

Route::get('/products/{id}', function ($id) {
    return view('product_detail', ['id' => $id]);
})->name('product.detail');


// Search Page
Route::get('/search', function () {
    return view('search');
})->name('product.search');

// Cart Page
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// Profile Page
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Orders Page
Route::get('/orders', function () {
    return view('orders');
})->name('orders');

// Wishlist Page
Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');

// Deals Page (if you create one)
Route::get('/deals', function () {
    return view('deals');
})->name('deals');

