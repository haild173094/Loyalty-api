<?php

use App\Http\Controllers\API\Merchant\ProductController as MerchantProductController;
use App\Http\Controllers\API\Shopify\CollectionController as ShopifyCollectionController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Shopify\ProductController as ShopifyProductController;
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

Route::namespace('API')->name('api.')->group(function () {
    Route::middleware(['verify.shopify'])->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'show'])->name('user.show');
        });
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products.index');
        });
        Route::prefix('shopify')->group(function () {
            Route::get('products', [ShopifyProductController::class, 'index'])->name('shopify.products.index');
            Route::get('collections', [ShopifyCollectionController::class, 'index'])->name('shopify.collections.index');
        });
    });

    Route::prefix('merchant')->group(function () {
        Route::prefix('product', [MerchantProductController::class, 'show'])->name('merchant.product.get');
    });
});
