<?php

namespace App\Services\Shopify\Graphql;

use App\Services\Shopify\BaseService;

class MetafieldService extends BaseService
{
    /**
     * Set metafield value using graphql
     *
     * @param array $params
     *
     * @return array
     */
    public function updateMetafield($params)
    {
        $query = <<<'GRAPHQL'
            mutation SetMetafields($metafields: [MetafieldsSetInput!]!) {
                metafieldsSet(metafields: $metafields) {
                    metafields {
                        id
                    }
                    userErrors {
                        field
                        message
                        code
                    }
                }
            }
            GRAPHQL;

        $response = $this->getShop()->graph($query, $params);

        return data_get($response, 'body.data.metafieldsSet.metafields.0.id');
    }

    /**
     * Set value for multiple metafields using graphql
     *
     * @param array $params
     *
     * @return array
     */
    public function updateMetafields($params)
    {
        $query = <<<'GRAPHQL'
            mutation SetMetafields($metafields: [MetafieldsSetInput!]!) {
                metafieldsSet(metafields: $metafields) {
                    metafields {
                        id
                        key
                    }
                    userErrors {
                        field
                        message
                        code
                    }
                }
            }
            GRAPHQL;

        $response = $this->getShop()->graph($query, $params);

        return data_get($response, 'body.data.metafieldsSet.metafields', []);
    }

    /**
     * Delete a metafield using graphql
     *
     * @param array $params
     *
     * @return array
     */
    public function deleteMetafield($params)
    {
        $query = <<<'GRAPHQL'
            mutation metafieldDelete($input: MetafieldDeleteInput!) {
                metafieldDelete(input: $input) {
                    deletedId
                    userErrors {
                        field
                        message
                    }
                }
            }
            GRAPHQL;

        $response = $this->getShop()->graph($query, $params);
        return data_get($response, 'body.data.metafieldDelete');
    }
}
