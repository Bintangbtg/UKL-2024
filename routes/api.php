<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CoffeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\transaksi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/admin/auth', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('getUsers', 'getUsers');
});

Route::post('/coffe',[CoffeController::class,'store']);
Route::get('/coffee/:search',[CoffeController::class,'index']);
Route::put('/coffee/{id}',[CoffeController::class,'update']);
Route::delete('/coffee/{id}',[CoffeController::class,'destroy']);
Route::get('/coffee/{id}',[CoffeController::class,'getcoffe']);

Route::post('/order',[OrderController::class,'store']);
Route::get('/order',[OrderController::class,'index']);

Route::post('order',[transaksi::class,'order']);
Route::post('tambahitem/{id}',[transaksi::class,'tambahItem']);
Route::get('getorder/{id}',[transaksi::class,'getdetail']);
Route::get('getorder',[transaksi::class,'getdetailall']);