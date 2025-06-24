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

Route::get('/users', [UserController::class, 'getAllUser']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::post('/check-email-send-code', [UserController::class, 'checkEmailandsendCode']);
Route::post('/check-code', [UserController::class, 'checkCode']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::get('/order-history/{id}', [UserController::class, 'orderHistory']);

use App\Http\Controllers\API\CategoryController;

Route::get('/subcategories', [CategoryController::class, 'getAllSubCategory']);
Route::get('/categories', [CategoryController::class, 'allCategory']);
Route::post('/createcategories', [CategoryController::class, 'createCategory']);
Route::post('/createsubcategories', [CategoryController::class, 'createSubCategory']);
Route::put('/categories/{id_category}', [CategoryController::class, 'updateCategory']);
Route::put('/subcategories/{id_subcategory}', [CategoryController::class, 'updateSubCategory']);

use App\Http\Controllers\API\ProductController;

Route::get('/products', [ProductController::class, 'getAllProduct']);
Route::post('/products', [ProductController::class, 'createProduct']);
Route::get('/featured-products', [ProductController::class, 'featuredProduct']);
Route::get('/new-products', [ProductController::class, 'newProduct']);
Route::get('/products-by-subcategory/{id_subcategory}', [ProductController::class, 'productsBySubCategory']);
Route::get('/products-by-category/{id_category}', [ProductController::class, 'getProductsByCategory']);
Route::get('/products/{id_product}', [ProductController::class, 'getProductDetail']);

use App\Http\Controllers\API\CartController;
//
Route::get('/cart/{id_user}', [CartController::class, 'indexCart']);
Route::post('/addtocart/{id_user}', [CartController::class, 'addToCart']);
Route::put('/updatecart/{id_user}', [CartController::class, 'updateCart']);
Route::delete('/deletecartproduct/{id_user}', [CartController::class, 'deleteProductToCart']);
Route::post('/checkout/{id_user}', [CartController::class, 'checkout']);
// guest order
Route::post('/guestcheckout', [CartController::class, 'guestCheckout']);
