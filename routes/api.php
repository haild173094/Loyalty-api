<?php

use App\Http\Controllers\API\CollectionController;
use App\Http\Controllers\API\DiscountBlueprintController;
use App\Http\Controllers\API\LoyaltyRuleController;
use App\Http\Controllers\API\Merchant\CustomerController as MerchantCustomerController;
use App\Http\Controllers\API\Merchant\CustomerDiscountController as MerchantCustomerDiscountController;
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
            Route::post('/', [ProductController::class, 'store'])->name('products.store');
            Route::put('{product}', [ProductController::class, 'update'])->name('products.update');
        });

        Route::prefix('collections')->group(function () {
            Route::get('/', [CollectionController::class, 'index'])->name('products.index');
            Route::post('/', [CollectionController::class, 'store'])->name('products.store');
            Route::put('{collection}', [CollectionController::class, 'update'])->name('products.update');
        });

        Route::prefix('discount-blueprints')->group(function () {
            Route::get('/', [DiscountBlueprintController::class, 'index'])->name('discount-blueprints.index');
            Route::post('/', [DiscountBlueprintController::class, 'store'])->name('discount-blueprints.store');
            Route::put('{discount_blueprint}', [DiscountBlueprintController::class, 'update'])->name('discount-blueprints.update');
            Route::delete('{discount_blueprint}', [DiscountBlueprintController::class, 'destroy'])->name('discount-blueprints.delete');
        });

        Route::prefix('loyalty-rules')->group(function () {
            Route::get('/', [LoyaltyRuleController::class, 'index'])->name('loyalty-rules.index');
            Route::post('/', [LoyaltyRuleController::class, 'store'])->name('loyalty-rules.store');
            Route::put('{loyalty_rule}', [LoyaltyRuleController::class, 'update'])->name('loyalty-rules.update');
            Route::delete('{loyalty_rule}', [LoyaltyRuleController::class, 'destroy'])->name('loyalty-rules.delete');
        });

        Route::prefix('shopify')->group(function () {
            Route::get('products', [ShopifyProductController::class, 'index'])->name('shopify.products.index');
            Route::get('collections', [ShopifyCollectionController::class, 'index'])->name('shopify.collections.index');
        });
    });

    Route::group([
        'prefix' => 'proxy',
        'middlewares' => ['auth.proxy'],
    ], function () {
        Route::get('customer', [MerchantCustomerController::class, 'show'])->name('proxy.customer.show');
        Route::get('customer/discounts', [MerchantCustomerDiscountController::class, 'index'])->name('proxy.customer.discount.index');
        Route::get('customer/discounts/redeem', [MerchantCustomerDiscountController::class, 'redeem'])->name('proxy.customer.discount.redeem');
    });
});
