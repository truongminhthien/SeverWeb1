<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

use App\Http\Controllers\API\UserController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::post('/check-email-send-code', [UserController::class, 'checkEmailandsendCode']);
Route::post('/check-code', [UserController::class, 'checkCode']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);

use App\Http\Controllers\API\CategoryController;

Route::get('/categories', [CategoryController::class, 'allCategory']);

use App\Http\Controllers\API\ProductController;

Route::get('/featured-products', [ProductController::class, 'featuredProduct']);
Route::get('/new-products', [ProductController::class, 'newProduct']);
