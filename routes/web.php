<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\CoffeController;
use App\Http\Controllers\OrderController;

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
    return view('login');
});

Route::view('/menu', 'home');
Route::view('/register', 'register');
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
Route::post('/transaksi/{barang}', [PembelianController::class, 'beli'])->name('transaksi.beli');
Route::get('/transaksi/{barang}', [PembelianController::class, 'create'])->name('transaksi.beli');
Route::get('/history', [PembelianController::class, 'index'])->name('pembelian.index');
Route::delete('/history/{pembelian}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');

Route::view('/history','history');
Route::view('/home','home2');
Route::view('/keranjang','keranjang');

Route::get('/coffe/create', [CoffeController::class, 'create'])->name('coffe.create');
Route::post('/coffe', [CoffeController::class, 'store'])->name('coffe.store');
Route::get('/coffe/edit/{coffe}', [CoffeController::class, 'edit'])->name('coffe.edit');
Route::put('/coffe/{id}', [BarangController::class, 'update'])->name('coffe.update');
Route::view('/transaksi','transaksi');