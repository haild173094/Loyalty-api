<?php

namespace App\Http\Controllers\API\Shopify;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopifyCollectionIndexRequest;
use App\Services\Shopify\Graphql\CollectionService;
use App\Http\Resources\ShopifyResource;

class CollectionController extends Controller
{
    /**
     * Get list of shopify collections
     *
     * @param \App\Http\Requests\ShopifyCollectionIndexRequest $request
     * @param \App\Services\Shopify\Graphql\CollectionService $collection_service
     */
    public function index(
        ShopifyCollectionIndexRequest $request,
        CollectionService $collection_service,
    ) {
        $input = $request->validated();
        return ShopifyResource::collection($collection_service->list($input));
    }
}
