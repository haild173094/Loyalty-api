<?php

namespace App\Enums;

use App\Traits\Enum;

enum ShopifyType: string
{
    use Enum;

    case Customer = 'Customer';
    case Product = 'Product';
    case ProductVariant = 'ProductVariant';
    case Order = 'Order';
    case LineItem = 'LineItem';
    case Shop = 'Shop';
    case MetafieldDefinition = 'MetafieldDefinition';
    case Metafield = 'Metafield';
    case Collection = 'Collection';
}
