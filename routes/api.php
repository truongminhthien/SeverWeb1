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
Route::post('/users/{id}', [UserController::class, 'updateUser']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::post('/check-email-send-code', [UserController::class, 'checkEmailandsendCode']);
Route::post('/check-code', [UserController::class, 'checkCode']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::get('/order-history/{id}', [UserController::class, 'orderHistory']);
Route::post('/users', [UserController::class, 'createUserAtAdmin']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
Route::put('/users/{id}/password', [UserController::class, 'updatePassword']);

use App\Http\Controllers\API\CategoryController;

Route::get('/subcategories', [CategoryController::class, 'getAllSubCategory']);
Route::get('/categories', [CategoryController::class, 'allCategory']);
Route::post('/createcategories', [CategoryController::class, 'createCategory']);
Route::post('/createsubcategories', [CategoryController::class, 'createSubCategory']);
Route::post('/categories/{id_category}', [CategoryController::class, 'updateCategory']);
Route::put('/subcategories/{id_subcategory}', [CategoryController::class, 'updateSubCategory']);
Route::delete('/categories/{id_category}', [CategoryController::class, 'deleteCategory']);

use App\Http\Controllers\API\ProductController;

Route::get('/products', [ProductController::class, 'getAllProduct']);
Route::post('/products', [ProductController::class, 'createProduct']);
Route::get('/featured-products', [ProductController::class, 'featuredProduct']);
Route::get('/new-products', [ProductController::class, 'newProduct']);
Route::get('/products-by-subcategory/{id_subcategory}', [ProductController::class, 'productsBySubCategory']);
Route::get('/products-by-category/{id_category}', [ProductController::class, 'getProductsByCategory']);
Route::get('/products/{id_product}', [ProductController::class, 'getProductDetail']);
Route::post('/products/{id_product}', [ProductController::class, 'updateProduct']);
Route::delete('/products/{id_product}', [ProductController::class, 'deleteProduct']);

Route::get('/reviews/product/{id_product}', [ProductController::class, 'getReviewByProduct']);
Route::get('/reviews', [ProductController::class, 'getAllReview']);
Route::post('/reviews', [ProductController::class, 'createReview']);

use App\Http\Controllers\API\CartController;
//
Route::get('/cart/{id_user}', [CartController::class, 'indexCart']);
Route::post('/addtocart/{id_user}', [CartController::class, 'addToCart']);
Route::put('/updatecart/{id_user}', [CartController::class, 'updateCart']);
Route::delete('/deletecartproduct/{id_user}', [CartController::class, 'deleteProductToCart']);
Route::post('/checkout/{id_user}', [CartController::class, 'checkout']);
Route::post('/applyvoucher/{id_user}', [CartController::class, 'applyVoucher']);
// guest order
Route::post('/guestcheckout', [CartController::class, 'guestCheckout']);

// Voucher management
Route::post('/vouchers', [CartController::class, 'createVoucher']);
Route::put('/vouchers/{id_voucher}', [CartController::class, 'updateVoucher']);
Route::get('/vouchers', [CartController::class, 'getVouchers']);
Route::delete('/vouchers/{id_voucher}', [CartController::class, 'deleteVoucher']);

// Order management
Route::get('/orders', [CartController::class, 'getAllOrder']);
Route::get('/orders/{id_order}', [CartController::class, 'getOrderById']);
Route::put('/orders/{id_order}/status', [CartController::class, 'updateStatusOrder']);
Route::put('/orders/{id_order}/cancel', [CartController::class, 'cancelOrder']);

use App\Http\Controllers\API\ArticleController;

Route::get('/articles', [ArticleController::class, 'getAllArticle']);
Route::post('/articles', [ArticleController::class, 'createArticle']);
Route::post('/articles/{id_articles}', [ArticleController::class, 'updateArticle']);
Route::delete('/articles/{id_articles}', [ArticleController::class, 'deleteArticle']);
