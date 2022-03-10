<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware('auth')->group(function(){
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class,'show']);
    Route::get('admin', [App\Http\Controllers\DashboardController::class,'show']);

    Route::get('admin/user/list', [App\Http\Controllers\AdminUserController::class,'list']);
    Route::get('admin/user/add', [App\Http\Controllers\AdminUserController::class,'add']);
    Route::post('admin/user/store', [App\Http\Controllers\AdminUserController::class,'store']);
    Route::get('admin/user/delete/{id}', [App\Http\Controllers\AdminUserController::class,'delete'])->name('delete.user');
    Route::get('admin/user/edit/{id}', [App\Http\Controllers\AdminUserController::class,'edit'])->name('edit.user');
    Route::post('admin/user/update/{id}', [App\Http\Controllers\AdminUserController::class,'update'])->name('user.update');
    Route::get('admin/user/action', [App\Http\Controllers\AdminUserController::class,'action']);


    Route::get('admin/category/list',[App\Http\Controllers\CategoryController::class,'list']);
    Route::post('admin/category/create',[App\Http\Controllers\CategoryController::class,'create'])->name('category.create');
    Route::get('admin/category/edit/{id}',[App\Http\Controllers\CategoryController::class,'edit'])->name('edit.category');
    Route::post('admin/category/update/{id}',[App\Http\Controllers\CategoryController::class,'update'])->name('update.category');
    Route::get('admin/category/delete/{id}',[App\Http\Controllers\CategoryController::class,'delete'])->name('delete.category');

    Route::get('admin/product/list', [App\Http\Controllers\ProductController::class,'list']);
    Route::get('admin/product/add', [App\Http\Controllers\ProductController::class,'add']);
    Route::post('admin/product/store', [App\Http\Controllers\ProductController::class,'store']);
    Route::get('admin/product/delete/{id}', [App\Http\Controllers\ProductController::class,'delete'])->name('delete.product');
    Route::get('admin/product/edit/{id}', [App\Http\Controllers\ProductController::class,'edit'])->name('edit.product');
    Route::post('admin/product/update/{id}', [App\Http\Controllers\ProductController::class,'update'])->name('update.product');
    Route::get('admin/product/action', [App\Http\Controllers\ProductController::class,'action']);
});

