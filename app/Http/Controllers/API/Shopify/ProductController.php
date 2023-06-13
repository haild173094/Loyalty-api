<?php

namespace App\Http\Controllers\API\Shopify;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopifyProductIndexRequest;
use App\Http\Resources\ShopifyResource;
use App\Services\Shopify\Graphql\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get list of shopify product
     *
     * @param \App\Http\Requests\ShopifyProductIndexRequest $request
     * @param \App\Services\Shopify\Graphql\ProductService $product_service
     */
    public function index(
        ShopifyProductIndexRequest $request,
        ProductService $product_service,
    ) {
        $input = $request->validated();
        return ShopifyResource::collection($product_service->list($input));
    }
}
