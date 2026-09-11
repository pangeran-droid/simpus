<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

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
        ->name('admin.user.update');
    Route::delete('/admin/users/{id}', [HomeController::class, 'destroy_user'])
        ->name('admin.user.destroy');

    /* Admin Routes Kategori */
    Route::get('/admin/kategori', [KategoriController::class, 'index'])
        ->name('admin.kategori');
    Route::get('/admin/kategori/create', [KategoriController::class, 'create_kategori'])
        ->name('admin.kategori.create');
    Route::post('/admin/kategori', [KategoriController::class, 'store_kategori'])
        ->name('admin.kategori.store');
    Route::get('/admin/kategori/{id}/edit', [KategoriController::class, 'edit_kategori'])
        ->name('admin.kategori.edit');
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update_kategori'])
        ->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy_kategori'])
        ->name('admin.kategori.destroy');

    /* Admin Routes Buku */
    Route::get('/admin/buku', [BukuController::class, 'index'])
        ->name('admin.buku');
    Route::get('/admin/buku/create', [BukuController::class, 'create_buku'])
        ->name('admin.buku.create');
    Route::post('/admin/buku', [BukuController::class, 'store_buku'])
        ->name('admin.buku.store');
    Route::get('/admin/buku/{id}/edit', [BukuController::class, 'edit_buku'])
        ->name('admin.buku.edit');
    Route::put('/admin/buku/{id}', [BukuController::class, 'update_buku'])
        ->name('admin.buku.update');
    Route::delete('/admin/buku/{id}', [BukuController::class, 'destroy_buku'])
        ->name('admin.buku.destroy');

    /* Admin Routes Rak */
    Route::get('/admin/rak', [RakController::class, 'index'])
        ->name('admin.rak');
    Route::get('/admin/rak/create', [RakController::class, 'create_rak'])
        ->name('admin.rak.create');
    Route::post('/admin/rak', [RakController::class, 'store_rak'])
        ->name('admin.rak.store');
    Route::get('/admin/rak/{id}/edit', [RakController::class, 'edit_rak'])
        ->name('admin.rak.edit');
    Route::put('/admin/rak/{id}', [RakController::class, 'update_rak'])
        ->name('admin.rak.update');
    Route::delete('/admin/rak/{id}', [RakController::class, 'destroy_rak'])
        ->name('admin.rak.destroy');

    /* Admin Routes Peminjaman */
    Route::get('/admin/transaksi/peminjaman', [TransaksiController::class, 'index'])
        ->name('admin.transaksi.peminjaman');
    Route::get('/admin/transaksi/peminjaman/create', [TransaksiController::class, 'create_peminjaman'])
        ->name('admin.transaksi.peminjaman.create');
    Route::post('/admin/transaksi/peminjaman', [TransaksiController::class, 'store_peminjaman'])
        ->name('admin.transaksi.peminjaman.store');
    Route::get('/admin/transaksi/peminjaman/{id}/detail', [TransaksiController::class, 'detail_peminjaman'])
        ->name('admin.transaksi.peminjaman.detail');
    Route::get('/admin/transaksi/peminjaman/{id}/edit', [TransaksiController::class, 'edit_peminjaman'])
        ->name('admin.transaksi.peminjaman.edit');
    Route::put('/admin/transaksi/peminjaman/{id}', [TransaksiController::class, 'update_peminjaman'])
        ->name('admin.transaksi.peminjaman.update');
    Route::delete('/admin/transaksi/peminjaman/{id}', [TransaksiController::class, 'destroy_peminjaman'])
        ->name('admin.transaksi.peminjaman.destroy');

    /* Admin Routes Pengembalian */
    Route::get('/admin/transaksi/pengembalian', [TransaksiController::class, 'pengembalian'])
        ->name('admin.transaksi.pengembalian');
    Route::post('/admin/transaksi/pengembalian/{id}', [TransaksiController::class, 'proses_pengembalian'])
        ->name('admin.transaksi.pengembalian.proses');

    /* Admin Routes Denda */
    Route::get('/admin/transaksi/denda', [TransaksiController::class, 'denda'])
        ->name('admin.transaksi.denda');

    /* Admin Routes Laporan */
    Route::get('/admin/laporan', [LaporanController::class, 'index'])
        ->name('admin.laporan');




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
