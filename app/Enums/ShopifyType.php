<?php
namespace App\Enums;

enum ShopifyType: string
{
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
