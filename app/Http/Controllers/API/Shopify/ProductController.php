<?php

namespace App\Http\Controllers\API\Shopify;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopifyProductIndexRequest;
use App\Http\Resources\ShopifyResource;
use App\Services\Shopify\Graphql\ProductService;
use App\Models\Product;

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
        ProductService $product_service
    ) {
        $input = $request->validated();
        $result = ShopifyResource::collection($product_service->list($input));
        $shopify_ids = $this->extractShopifyIdFromShopifyResource($result);
        $products = Product::whereIn('shopify_id', $shopify_ids)->get();
        $result['products'] = $products;
        return $result;
    }

    /**
     * Extract product ids from shopify product collection
     *
     * @param array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection $resource
     */
    protected function extractShopifyIdFromShopifyResource($resources)
    {
        $data = data_get($resources, 'data');
        return collect($data)->map(function ($product) {
            return $this->getIdFromShopifyId(data_get($product, 'id'));
        })->toArray();
    }

    /**
     * Get id from shopif id
     *
     * @return string
     */
    protected function getIdFromShopifyId($gid)
    {
        $last_slash_pos = strrpos($gid, '/');

        if ($last_slash_pos === false) {
            return $gid;
        }

        return substr($gid, $last_slash_pos + 1);
    }
}
