<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\DisableCsrfProtection;
use App\Http\Controllers\AppController;
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


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth','verifyemail'])->group(function(){
    
    Route::get('/email/verify', function () {
        return view('confirmacionView');
    })->name('verification.notice');
    
    
});

Route::get('/login/verify/{id}', [AuthController::class, 'verifyemail'])->middleware('signed')->name('login.verify');
Route::post('/login', [AuthController::class, 'login'])->name('PLogin');
Route::post('/code/verify', [AuthController::class, 'verifycode'])->name('code.verify');
Route::middleware('verifyemail')->group(function(){
    Route::get('/products',[AuthController::class, 'gethome'])->name('products');
});

Route::redirect('/', '/login');
#####################################33


Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('auth');

Route::middleware([CheckRole::class . ':1,2'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

##########################################3
Route::middleware([CheckRole::class . ':1'])->group(function () {
Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [AuthController::class, 'index'])->name('users.store');

Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});



Route::post('/obtener', [AuthController::class, 'prueba']);

Route::middleware([DisableCsrfProtection::class])->group(function () {
    // Aquí van tus rutas que no necesitan protección CSRF
    Route::post('/1', [AuthController::class, 'index']);
});


Route::post('/loginb', [LoginController::class, 'loginb']);


//Route::post('/validar_usuario', 'AppController@validarUsuario');

Route::match(['get', 'post'], '/validar_usuario', [AppController::class, 'validarUsuario']);

Route::match(['get', 'post'], '/validar_codigo', [AppController::class, 'validarCodigo']);

Route::match(['get', 'post'], '/code_admin', [AppController::class, 'codeAdmin']);