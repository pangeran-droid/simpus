<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;

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
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    /* Admin Routes Users */
    Route::get('/admin', [HomeController::class, 'index'])
        ->name('admin.home');
    Route::get('/admin/users', [HomeController::class, 'show_user'])
        ->name('admin.users');
    Route::get('/admin/users/create', [HomeController::class, 'create_user'])
        ->name('admin.users.create');
    Route::post('/admin/users', [HomeController::class, 'store_user'])
        ->name('admin.users.store');
    Route::get('/admin/users/{id}/edit', [HomeController::class, 'edit_user'])
        ->name('admin.users.edit');
    Route::put('/admin/users/{id}', [HomeController::class, 'update_user'])
        ->name('update_user');
    Route::delete('/admin/users/{id}', [HomeController::class, 'destroy_user'])
        ->name('destroy_user');

    /* Admin Routes Kategori */
    Route::get('/admin/kategori', [KategoriController::class, 'index'])
        ->name('admin.kategori');
    Route::get('/admin/kategori/create', [KategoriController::class, 'create_kategori'])
        ->name('admin.kategori.create');
    Route::post('/admin/kategori', [KategoriController::class, 'store_kategori'])
        ->name('store_kategori');
    Route::get('/admin/kategori/{id}/edit', [KategoriController::class, 'edit_kategori'])
        ->name('admin.kategori.edit');
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update_kategori'])
        ->name('update_kategori');
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy_kategori'])
        ->name('destroy_kategori');

    /* Admin Routes Buku */
    Route::get('/admin/buku', [BukuController::class, 'index'])
        ->name('admin.buku');
    Route::get('/admin/buku/create', [BukuController::class, 'create_buku'])
        ->name('admin.buku.create');
    Route::post('/admin/buku', [BukuController::class, 'store_buku'])
        ->name('store_buku');
    Route::get('/admin/buku/{id}/edit', [BukuController::class, 'edit_buku'])
        ->name('admin.buku.edit');
    Route::put('/admin/buku/{id}', [BukuController::class, 'update_buku'])
        ->name('update_buku');
    Route::delete('/admin/buku/{id}', [BukuController::class, 'destroy_buku'])
        ->name('destroy_buku');



    /* Users Routes */
    Route::get('/user', [UserController::class, 'index'])
        ->name('user.index');


    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
