<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;

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

//Route::get('test', [TestController::class, 'index']);

Route::post('/register',[AuthController::class, 'register'])->name('register.api');
Route::post('/login', [AuthController::class, 'login'])->name('login.api');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify.api');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/current', [AuthController::class, 'current'])->name('current.api');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.api');
});
