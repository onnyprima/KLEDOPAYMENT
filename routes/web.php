<?php

use App\Http\Controllers\PaymentController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payments', [PaymentController::class, 'get'])->name('payments');
Route::post('/payments', [PaymentController::class, 'post']);
Route::post('/payments/delete', [PaymentController::class, 'delete'])->name('paymentsdelete');
