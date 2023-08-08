# Details

Date : 2023-08-02 16:00:50

Directory /home/hai/code/loyalty-point-app/scaffolding-api-2023/app

Total : 81 files,  2519 codes, 963 comments, 602 blanks, all 4084 lines

[Summary](results.md) / Details / [Diff Summary](diff.md) / [Diff Details](diff-details.md)

## Files
| filename | language | code | comment | blank | total |
| :--- | :--- | ---: | ---: | ---: | ---: |
| [app/Console/Commands/ResetUsersWebhooks.php](/app/Console/Commands/ResetUsersWebhooks.php) | PHP | 43 | 13 | 9 | 65 |
| [app/Console/Commands/SyncDiscountBlueprintToShopify.php](/app/Console/Commands/SyncDiscountBlueprintToShopify.php) | PHP | 40 | 13 | 7 | 60 |
| [app/Console/Commands/SyncLoyaltyRuleToShopify.php](/app/Console/Commands/SyncLoyaltyRuleToShopify.php) | PHP | 40 | 13 | 7 | 60 |
| [app/Console/Kernel.php](/app/Console/Kernel.php) | PHP | 15 | 7 | 6 | 28 |
| [app/Enums/CollectionStatus.php](/app/Enums/CollectionStatus.php) | PHP | 7 | 0 | 3 | 10 |
| [app/Enums/DiscountApplicationType.php](/app/Enums/DiscountApplicationType.php) | PHP | 7 | 0 | 3 | 10 |
| [app/Enums/DiscountBlueprintStatus.php](/app/Enums/DiscountBlueprintStatus.php) | PHP | 7 | 0 | 3 | 10 |
| [app/Enums/DiscountType.php](/app/Enums/DiscountType.php) | PHP | 7 | 0 | 3 | 10 |
| [app/Enums/LoyaltyRuleApplicationType.php](/app/Enums/LoyaltyRuleApplicationType.php) | PHP | 7 | 0 | 3 | 10 |
| [app/Enums/LoyaltyRuleStatus.php](/app/Enums/LoyaltyRuleStatus.php) | PHP | 7 | 0 | 3 | 10 |
| [app/Enums/ProductStatus.php](/app/Enums/ProductStatus.php) | PHP | 7 | 0 | 3 | 10 |
| [app/Enums/ShopifyType.php](/app/Enums/ShopifyType.php) | PHP | 14 | 0 | 2 | 16 |
| [app/Exceptions/Handler.php](/app/Exceptions/Handler.php) | PHP | 21 | 21 | 7 | 49 |
| [app/Exceptions/ShopifyGraphqlException.php](/app/Exceptions/ShopifyGraphqlException.php) | PHP | 35 | 19 | 10 | 64 |
| [app/Exceptions/ShopifyGraphqlUserError.php](/app/Exceptions/ShopifyGraphqlUserError.php) | PHP | 24 | 13 | 9 | 46 |
| [app/Http/Controllers/API/CollectionController.php](/app/Http/Controllers/API/CollectionController.php) | PHP | 42 | 25 | 10 | 77 |
| [app/Http/Controllers/API/DiscountBlueprintController.php](/app/Http/Controllers/API/DiscountBlueprintController.php) | PHP | 51 | 25 | 11 | 87 |
| [app/Http/Controllers/API/LoyaltyRuleController.php](/app/Http/Controllers/API/LoyaltyRuleController.php) | PHP | 51 | 24 | 12 | 87 |
| [app/Http/Controllers/API/Merchant/CustomerController.php](/app/Http/Controllers/API/Merchant/CustomerController.php) | PHP | 18 | 7 | 4 | 29 |
| [app/Http/Controllers/API/Merchant/CustomerDiscountController.php](/app/Http/Controllers/API/Merchant/CustomerDiscountController.php) | PHP | 49 | 13 | 12 | 74 |
| [app/Http/Controllers/API/Merchant/ProductController.php](/app/Http/Controllers/API/Merchant/ProductController.php) | PHP | 23 | 7 | 9 | 39 |
| [app/Http/Controllers/API/ProductController.php](/app/Http/Controllers/API/ProductController.php) | PHP | 45 | 25 | 10 | 80 |
| [app/Http/Controllers/API/Shopify/CollectionController.php](/app/Http/Controllers/API/Shopify/CollectionController.php) | PHP | 16 | 6 | 4 | 26 |
| [app/Http/Controllers/API/Shopify/ProductController.php](/app/Http/Controllers/API/Shopify/ProductController.php) | PHP | 32 | 16 | 8 | 56 |
| [app/Http/Controllers/API/UserController.php](/app/Http/Controllers/API/UserController.php) | PHP | 12 | 7 | 4 | 23 |
| [app/Http/Controllers/Controller.php](/app/Http/Controllers/Controller.php) | PHP | 9 | 0 | 4 | 13 |
| [app/Http/Controllers/HomeController.php](/app/Http/Controllers/HomeController.php) | PHP | 24 | 7 | 5 | 36 |
| [app/Http/Kernel.php](/app/Http/Kernel.php) | PHP | 40 | 21 | 7 | 68 |
| [app/Http/Middleware/Authenticate.php](/app/Http/Middleware/Authenticate.php) | PHP | 11 | 3 | 4 | 18 |
| [app/Http/Middleware/EncryptCookies.php](/app/Http/Middleware/EncryptCookies.php) | PHP | 8 | 6 | 4 | 18 |
| [app/Http/Middleware/PreventRequestsDuringMaintenance.php](/app/Http/Middleware/PreventRequestsDuringMaintenance.php) | PHP | 8 | 6 | 4 | 18 |
| [app/Http/Middleware/RedirectIfAuthenticated.php](/app/Http/Middleware/RedirectIfAuthenticated.php) | PHP | 20 | 5 | 6 | 31 |
| [app/Http/Middleware/TrimStrings.php](/app/Http/Middleware/TrimStrings.php) | PHP | 11 | 5 | 4 | 20 |
| [app/Http/Middleware/TrustHosts.php](/app/Http/Middleware/TrustHosts.php) | PHP | 12 | 5 | 4 | 21 |
| [app/Http/Middleware/TrustProxies.php](/app/Http/Middleware/TrustProxies.php) | PHP | 14 | 10 | 5 | 29 |
| [app/Http/Middleware/ValidateSignature.php](/app/Http/Middleware/ValidateSignature.php) | PHP | 8 | 11 | 4 | 23 |
| [app/Http/Middleware/VerifyCsrfToken.php](/app/Http/Middleware/VerifyCsrfToken.php) | PHP | 8 | 6 | 4 | 18 |
| [app/Http/Requests/CollectionIndexRequest.php](/app/Http/Requests/CollectionIndexRequest.php) | PHP | 51 | 11 | 12 | 74 |
| [app/Http/Requests/CollectionStoreRequest.php](/app/Http/Requests/CollectionStoreRequest.php) | PHP | 19 | 8 | 5 | 32 |
| [app/Http/Requests/CollectionUpdateRequest.php](/app/Http/Requests/CollectionUpdateRequest.php) | PHP | 18 | 8 | 5 | 31 |
| [app/Http/Requests/DiscountBlueprintIndexRequest.php](/app/Http/Requests/DiscountBlueprintIndexRequest.php) | PHP | 52 | 11 | 12 | 75 |
| [app/Http/Requests/DiscountBlueprintStoreRequest.php](/app/Http/Requests/DiscountBlueprintStoreRequest.php) | PHP | 31 | 8 | 5 | 44 |
| [app/Http/Requests/DiscountBlueprintUpdateRequest.php](/app/Http/Requests/DiscountBlueprintUpdateRequest.php) | PHP | 28 | 8 | 5 | 41 |
| [app/Http/Requests/LoyaltyRuleIndexRequest.php](/app/Http/Requests/LoyaltyRuleIndexRequest.php) | PHP | 58 | 11 | 12 | 81 |
| [app/Http/Requests/LoyaltyRuleStoreRequest.php](/app/Http/Requests/LoyaltyRuleStoreRequest.php) | PHP | 25 | 8 | 5 | 38 |
| [app/Http/Requests/LoyaltyRuleUpdateRequest.php](/app/Http/Requests/LoyaltyRuleUpdateRequest.php) | PHP | 23 | 8 | 5 | 36 |
| [app/Http/Requests/Merchant/CustomerDiscountIndexRequest.php](/app/Http/Requests/Merchant/CustomerDiscountIndexRequest.php) | PHP | 17 | 8 | 5 | 30 |
| [app/Http/Requests/Merchant/CustomerDiscountRedeemRequest.php](/app/Http/Requests/Merchant/CustomerDiscountRedeemRequest.php) | PHP | 18 | 8 | 5 | 31 |
| [app/Http/Requests/Merchant/CustomerGetRequest.php](/app/Http/Requests/Merchant/CustomerGetRequest.php) | PHP | 17 | 8 | 5 | 30 |
| [app/Http/Requests/Merchant/GetProductLoyaltyInfoRequest.php](/app/Http/Requests/Merchant/GetProductLoyaltyInfoRequest.php) | PHP | 17 | 8 | 5 | 30 |
| [app/Http/Requests/ProductIndexRequest.php](/app/Http/Requests/ProductIndexRequest.php) | PHP | 53 | 11 | 12 | 76 |
| [app/Http/Requests/ProductStoreRequest.php](/app/Http/Requests/ProductStoreRequest.php) | PHP | 19 | 8 | 5 | 32 |
| [app/Http/Requests/ProductUpdateRequest.php](/app/Http/Requests/ProductUpdateRequest.php) | PHP | 18 | 8 | 5 | 31 |
| [app/Http/Requests/ShopifyCollectionIndexRequest.php](/app/Http/Requests/ShopifyCollectionIndexRequest.php) | PHP | 47 | 12 | 11 | 70 |
| [app/Http/Requests/ShopifyProductIndexRequest.php](/app/Http/Requests/ShopifyProductIndexRequest.php) | PHP | 46 | 12 | 10 | 68 |
| [app/Http/Requests/ShopifyResourceIndexRequest.php](/app/Http/Requests/ShopifyResourceIndexRequest.php) | PHP | 32 | 20 | 10 | 62 |
| [app/Http/Resources/ShopifyResource.php](/app/Http/Resources/ShopifyResource.php) | PHP | 79 | 18 | 22 | 119 |
| [app/Http/Resources/UserResource.php](/app/Http/Resources/UserResource.php) | PHP | 68 | 5 | 4 | 77 |
| [app/Jobs/AppUninstalledJob.php](/app/Jobs/AppUninstalledJob.php) | PHP | 5 | 0 | 3 | 8 |
| [app/Jobs/OrdersUpdatedJob.php](/app/Jobs/OrdersUpdatedJob.php) | PHP | 87 | 30 | 21 | 138 |
| [app/Jobs/UpdateShopProfile.php](/app/Jobs/UpdateShopProfile.php) | PHP | 26 | 12 | 7 | 45 |
| [app/Models/Collection.php](/app/Models/Collection.php) | PHP | 34 | 23 | 10 | 67 |
| [app/Models/Customer.php](/app/Models/Customer.php) | PHP | 28 | 20 | 8 | 56 |
| [app/Models/Discount.php](/app/Models/Discount.php) | PHP | 32 | 16 | 9 | 57 |
| [app/Models/DiscountBlueprint.php](/app/Models/DiscountBlueprint.php) | PHP | 135 | 53 | 20 | 208 |
| [app/Models/LoyaltyRule.php](/app/Models/LoyaltyRule.php) | PHP | 85 | 34 | 18 | 137 |
| [app/Models/Order.php](/app/Models/Order.php) | PHP | 23 | 15 | 7 | 45 |
| [app/Models/Product.php](/app/Models/Product.php) | PHP | 76 | 37 | 15 | 128 |
| [app/Models/User.php](/app/Models/User.php) | PHP | 135 | 50 | 24 | 209 |
| [app/Providers/AppServiceProvider.php](/app/Providers/AppServiceProvider.php) | PHP | 12 | 8 | 5 | 25 |
| [app/Providers/AuthServiceProvider.php](/app/Providers/AuthServiceProvider.php) | PHP | 11 | 11 | 5 | 27 |
| [app/Providers/BroadcastServiceProvider.php](/app/Providers/BroadcastServiceProvider.php) | PHP | 12 | 3 | 5 | 20 |
| [app/Providers/EventServiceProvider.php](/app/Providers/EventServiceProvider.php) | PHP | 21 | 12 | 6 | 39 |
| [app/Providers/HorizonServiceProvider.php](/app/Providers/HorizonServiceProvider.php) | PHP | 19 | 12 | 6 | 37 |
| [app/Providers/RouteServiceProvider.php](/app/Providers/RouteServiceProvider.php) | PHP | 28 | 13 | 8 | 49 |
| [app/Services/Shopify/BaseService.php](/app/Services/Shopify/BaseService.php) | PHP | 15 | 16 | 6 | 37 |
| [app/Services/Shopify/Graphql/CollectionService.php](/app/Services/Shopify/Graphql/CollectionService.php) | PHP | 32 | 7 | 6 | 45 |
| [app/Services/Shopify/Graphql/DiscountService.php](/app/Services/Shopify/Graphql/DiscountService.php) | PHP | 54 | 7 | 6 | 67 |
| [app/Services/Shopify/Graphql/MetafieldService.php](/app/Services/Shopify/Graphql/MetafieldService.php) | PHP | 61 | 21 | 11 | 93 |
| [app/Services/Shopify/Graphql/ProductService.php](/app/Services/Shopify/Graphql/ProductService.php) | PHP | 32 | 7 | 6 | 45 |
| [app/Services/Shopify/REST/ShopService.php](/app/Services/Shopify/REST/ShopService.php) | PHP | 27 | 10 | 8 | 45 |

[Summary](results.md) / Details / [Diff Summary](diff.md) / [Diff Details](diff-details.md)