<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('auth')->group(function() {
    Route::get('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/logout', function() {
        Auth::logout();
    });

    Route::middleware('auth:sanctum')->get('/getUser', function (Request $request) {
    return [
        'user' => $request->user()
    ];
});

});

Route::prefix('categories')->group(function() {
    Route::get('/get', [CategoryController::class, 'get']);
    Route::get('/{categoryId}/products', [ProductController::class, 'getCategoryProducts']);
});


Route::get('/categories/{categoryId}', [CategoryController::class, 'show']);
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile');
Route::get('categories/{categoryId}/products', [ProductController::class, 'getCategoryProducts']);

Route::get('/products/get', [ProductController::class, 'get']);


Route::prefix('admin')->middleware('admin')->group(function() {
    Route::get('/categories/get', [CategoryController::class, 'get']);
    Route::get('/categoriesList', [CategoryController::class, 'list'])->name('categories');
    Route::post('/categories/create', [CategoryController::class, 'create']);
	Route::post('/categories/deleteCategory/{id}', [CategoryController::class, 'deleteCategory']);
    Route::post('/products/create', [ProductController::class, 'create']);
    Route::get('/products', [ProductController::class, 'list'])->name('products');
});


Route::prefix('order')->middleware('auth')->group(function() {
    Route::get('{orderId}/products', [OrderController::class, 'products']);
    Route::get('cart', [OrderController::class, 'cart'])->name('cart');
    Route::get('finish', [OrderController::class, 'finish']);
    Route::get('get', [OrderController::class, 'orders']);
    Route::post('addProduct', [OrderController::class, 'addProduct']);
    Route::post('removeProduct', [OrderController::class, 'removeProduct']);
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');