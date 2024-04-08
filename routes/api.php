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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/loginb', [LoginController::class, 'loginb']);

Route::post('/obtener', [AuthController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/ruta-usuario', [AuthController::class, 'rutaUsuario']);


Route::post('/recaptcha',[AuthController::class, 'recaptcha']);

//Route::post('/1', [AuthController::class, 'index']);

//Route::prefix('v1/persons')->group(function(){
  //  Route::post('/1', [AuthController::class, 'index']);
// });

