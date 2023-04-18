<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('login', [AuthController::class, 'loginView'])->middleware('alreadyLoggedIn');
Route::get('register', [AuthController::class, 'registerView'])->middleware('alreadyLoggedIn');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('dashboard', [AuthController::class, 'dashboard'])->middleware('isLoggedIn');
Route::get('logout', [AuthController::class, 'logout']);
Route::post('check-email', [AuthController::class, 'checkEmail']);
