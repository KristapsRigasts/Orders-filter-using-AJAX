<?php

use App\Http\Controllers\PendingOrderController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [PendingOrderController::class, 'index']);

Route::get('get-more-orders', [PendingOrderController::class, 'getMoreOrders'])->name('get-more-orders');
