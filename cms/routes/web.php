<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\OrderController; //追加
use App\Models\Order; //追加

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

//オーダー：ダッシュボード表示(order.blade.php)
Route::get('/', [OrderController::class,'index'])->middleware(['auth'])->name('order_index');
Route::get('/dashboard', [OrderController::class,'index'])->middleware(['auth'])->name('dashboard');

//オーダー：追加 
Route::post('/orders',[OrderController::class,"store"])->name('order_store');

//オーダー：削除 
Route::delete('/order/{order}', [OrderController::class,"destroy"])->name('order_destroy');

//オーダー：更新画面
Route::post('/ordersedit/{order}',[OrderController::class,"edit"])->name('order_edit'); //通常
Route::get('/ordersedit/{order}', [OrderController::class,"edit"])->name('edit');      //Validationエラーありの場合

//オーダー：更新画面
Route::post('/orders/update',[OrderController::class,"update"])->name('order_update');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
