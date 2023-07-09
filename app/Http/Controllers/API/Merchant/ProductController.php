<?php

namespace App\Http\Controllers\API\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\GetProductLoyaltyInfoRequest;
use App\Models\Collection;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Get product loyalty information
     *
     * @param \App\Http\Requests\Merchant\GetProductLoyaltyInfoRequest $request
     *
     * @return mixed
     */
    public function get(GetProductLoyaltyInfoRequest $request)
    {
        $input = $request->validated();

        $product = Product::where('shopify_id', $input['product_id'])->first();

        if ($product) {
            return $product;
        }

        $collection_ids = explode(',', $input['collection_ids']);
        $collection = Collection::whereIn('shopify_id', $collection_ids)->orderBy('id', 'desc')->first();

        if ($collection) {
            return $collection;
        }

        return new Response('Not found', 404);
    }
}
