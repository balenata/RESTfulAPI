<?php

use Illuminate\Http\Request;

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
// buyers
Route::resource('buyers' , 'buyer\buyerController',['only' => ['index','show']]);
Route::resource('buyers.transactions' , 'Buyer\BuyerTransactionController',['only' => ['index']]);
Route::resource('buyers.products' , 'Buyer\BuyerProductController',['only' => ['index']]);
Route::resource('buyers.sellers' , 'Buyer\BuyerSellerController',['only' => ['index']]);
Route::resource('buyers.categories' , 'Buyer\BuyerCategoryController',['only' => ['index']]);
// categories
Route::resource('categories','category\categoryController',['except' => ['create','edit']]);
Route::resource('categories.products','Category\CategoryProductController',['only' => ['index']]);
Route::resource('categories.sellers','Category\CategorySellerController',['only' => ['index']]);
Route::resource('categories.transactions','Category\CategoryTransactionController',['only' => ['index']]);
Route::resource('categories.buyers','Category\CategoryBuyerController',['only' => ['index']]);
// PRODUCT
Route::resource('products','product\productController',['only' => ['index','show']]);
Route::resource('products.transactions','Product\ProductTransactionController',['only' => ['index']]);
Route::resource('products.buyers','Product\ProductBuyerController',['only' => ['index']]);
Route::resource('products.buyers.transactions','Product\ProductBuyerTransactionController',['only' => ['store']]);
Route::resource('products.categories','Product\ProductCategoryController',['only' => ['index','update','destroy']]);
// sellers
Route::resource('sellers','seller\sellerController',['only' => ['index','show']]);
Route::resource('sellers.transactions','seller\sellerTransactionController',['only' => ['index']]);
Route::resource('sellers.categories','seller\sellerCategoryController',['only' => ['index']]);
Route::resource('sellers.buyers','seller\sellerBuyerController',['only' => ['index']]);
Route::resource('sellers.products','seller\sellerProductController',['except' => ['create','show','edit']]);
// transaction
Route::resource('transactions','transaction\transactionController',['only' => ['index','show']]);
Route::resource('transactions.categories','Transaction\TransactionCategoryController',['only' => ['index']]);
Route::resource('transactions.sellers','Transaction\TransactionSellerController',['only' => ['index']]);
// user
Route::resource('users','user\userController',['except' => ['create','edit']]);
Route::name('verify')->get('users/verify/{token}','User\UserController@verify');
Route::name('resend')->get('users/{user}/resend','User\UserController@resend');
