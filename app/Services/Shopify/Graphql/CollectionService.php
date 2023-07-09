<?php

namespace App\Services\Shopify\Graphql;

use App\Services\Shopify\BaseService;

class CollectionService extends BaseService
{
    /**
     * Get collections
     *
     * @param $params
     * @return array|\GuzzleHttp\Promise\Promise|Collection
     * @throws \App\Exceptions\ShopifyGraphqlException
     */
    public function list($params)
    {
        $query = <<<'GRAPHQL'
            query GetCollections($before: String, $after: String, $first: Int, $last: Int, $query: String) {
                products(before: $before, after: $after, first: $first, last: $last, query: $query) {
                    edges {
                        cursor
                        node {
                            id
                            title
                            handle
                            image {
                                url
                            }
                        }
                    }
                    pageInfo {
                        hasNextPage
                        hasPreviousPage
                    }
                }
            }
            GRAPHQL;

        $response = $this->getShop()->graph($query, $params);

        return data_get($response, 'body.data.collections');
    }
}
