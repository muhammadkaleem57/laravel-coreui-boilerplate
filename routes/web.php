<?php

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

Route::get('/', fn() => view('auth.login'));

Route::prefix('admin')->middleware(['auth:sanctum', 'verified', 'auth.isAdmin'])->group(function (){

    Route::get('dashboard', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');

});
