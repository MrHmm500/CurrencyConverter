<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

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

Route::get(\App\Providers\RouteServiceProvider::HOME,
    function () {
        return view('home');
    })
    ->name('home');

Route::post(\App\Providers\RouteServiceProvider::LOGOUT,
    function () {
        \App\Http\Controllers\LogoutController::logout();
        return redirect('/');
    })
    ->name('convert')
    ->middleware('auth');

Route::post(\App\Providers\RouteServiceProvider::LOGIN,
    [
        \App\Http\Controllers\LoginController::class, 'login'
    ])
    ->name('login');

Route::post('/register', [RegisterController::class, 'store']);
