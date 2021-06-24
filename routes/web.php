<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [CategoryController::class, 'welcome'])->name('welcome');
Route::get('/categories/{categoryId}', [CategoryController::class, 'show']);

Route::get('/products/get', [ProductController::class, 'get']);


Route::prefix('admin')->middleware('admin')->group(function() {
    Route::get('/categoriesList', [CategoryController::class, 'list'])->name('categories');
    Route::post('/categories/create', [CategoryController::class, 'create']);
    Route::post('/products/create', [ProductController::class, 'create']);
    Route::get('/products', [ProductController::class, 'list'])->name('products');
    Route::get('/categories/get', [CategoryController::class, 'get']);
});


Route::prefix('order')->middleware('auth')->group(function() {
    Route::get('cart', [OrderController::class, 'cart'])->name('cart');
    Route::post('addProduct', [OrderController::class, 'addProduct']);
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
