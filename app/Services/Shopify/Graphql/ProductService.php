<?php

namespace App\Services\Shopify\Graphql;

use App\Services\Shopify\BaseService;

class ProductService extends BaseService
{
    /**
     * Get products
     *
     * @param $params
     * @return array|\GuzzleHttp\Promise\Promise|Collection
     * @throws \App\Exceptions\ShopifyGraphqlException
     */
    public function list($params)
    {
        $query = <<<'GRAPHQL'
            query GetProducts($before: String, $after: String, $first: Int, $last: Int, $query: String) {
                products(before: $before, after: $after, first: $first, last: $last, query: $query) {
                    edges {
                        cursor
                        node {
                            id
                            title
                            handle
                            image: featuredImage {
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

        return data_get($response, 'body.data.products');
    }
}
