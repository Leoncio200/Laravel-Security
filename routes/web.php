<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Http\Request;
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

Route::get('/login',[AuthController::class, 'getlogin'])->name('login');

Route::get('/registro',[AuthController::class, 'getregistro']);
Route::post('/registrar',[AuthController::class, 'registrar'])->name('register');

Route::middleware(['auth','verifyemail'])->group(function(){
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/email/verify', function () {
        return view('confirmacionView');
    })->name('verification.notice');
    
    
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login/verify/{id}', [AuthController::class, 'verifyemail'])->middleware('signed')->name('login.verify');
Route::post('/login', [AuthController::class, 'login'])->name('PLogin');
Route::post('/login', [AuthController::class, 'login'])->name('PLogin');
Route::middleware('verifyemail')->group(function(){
    Route::get('/home',[AuthController::class, 'gethome'])->name('home');
});

Route::redirect('/', '/login');