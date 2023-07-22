<?php

namespace App\Services\Shopify\Graphql;

use App\Services\Shopify\BaseService;

class DiscountService extends BaseService
{
    /**
     * Create basic discount code
     *
     * @param $params
     * @return array|\GuzzleHttp\Promise\Promise|Collection
     * @throws \App\Exceptions\ShopifyGraphqlException
     */
    public function createBasicDiscount($params)
    {
        $query = <<<'GRAPHQL'
            mutation discountCodeBasicCreate($basicCodeDiscount: DiscountCodeBasicInput!) {
                discountCodeBasicCreate(basicCodeDiscount: $basicCodeDiscount) {
                    codeDiscountNode {
                        codeDiscount {
                            ... on DiscountCodeBasic {
                                title
                                codes(first: 10) {
                                    nodes {
                                        code
                                    }
                                }
                                startsAt
                                endsAt
                                customerSelection {
                                    ... on DiscountCustomerAll {
                                        allCustomers
                                    }
                                }
                                customerGets {
                                    value {
                                        ... on DiscountPercentage {
                                            percentage
                                        }
                                    }
                                    items {
                                        ... on AllDiscountItems {
                                            allItems
                                        }
                                    }
                                }
                                appliesOncePerCustomer
                            }
                        }
                    }
                    userErrors {
                        field
                        code
                        message
                    }
                }
            } 
            GRAPHQL;

        $response = $this->getShop()->graph($query, $params);

        return data_get($response, 'body.data.discountCodeBasicCreate.codeDiscountNode.codeDiscount');
    }
}
