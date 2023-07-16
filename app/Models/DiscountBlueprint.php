<?php

namespace App\Models;

use App\Enums\DiscountApplicationType;
use App\Enums\DiscountType;
use App\Services\Shopify\Graphql\MetafieldService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class DiscountBlueprint extends Model
{
    use HasFactory;

    /**
     * @var int
     */
    const METAFIELD_KEY_LENGTH = 12;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'amount',
        'loyalty_price',
        'customer_selection',
        'time_limit',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'type' => DiscountType::class,
        'customer_selection' => DiscountApplicationType::class,
    ];

    /**
     * Belongs to relationship with user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sync discount blueprint data to shopify metafield
     */
    public function syncMetafield()
    {
        $metafield_service = App::make(MetafieldService::class);
        $owner_id = $this->user->getShopifyGraphqlId();

        if ($owner_id) {
            $metafield_service->updateMetafields(
                [
                    [
                        'ownerId' => $owner_id,
                        'type' => 'json',
                        'namespace' => config('app.custom.metafield.prize_namespace'),
                        'key' => $this->getMetafieldKey(),
                        'value' => json_encode($this->only($this->fillable)),
                    ],
                ],
            );
        }
    }

    /**
     * Get metafield key
     *
     * @return string
     */
    public function getMetafieldKey()
    {
        return sprintf("%0" . self::METAFIELD_KEY_LENGTH . "d", $this->id);
    }

    /**
     * Get discount value
     *
     * @return array
     */
    public function getDiscountValue()
    {
        if ($this->type == DiscountType::Amount) {
            return [
                'discountAmount' => [
                    'amount' => $this->amount,
                    'appliesOnEachItem' => false,
                ],
            ];
        } else {
            return [
                'percentage' => $this->amount / 100,
            ];
        }
    }

    /**
     * Get customer selection
     *
     * @param \App\Models\Customer $customer
     * @return array
     */
    public function getCustomerSelections(Customer $customer)
    {
        if ($this->customer_selection == DiscountApplicationType::All) {
            return [
                'all' => true,
            ];
        } else {
            return [
                'customers' => [
                    'add' => $customer->shopify_id,
                ],
            ];
        }
    }

    /**
     * Get shopify input for creating discount
     *
     * @param \App\Models\Customer $customer
     * @return array
     */
    public function toShopify(Customer $customer)
    {
        return [
            'appliesOncePerCustomer' => true,
            'code' => 'Cringe as fuck',
            'combinesWith' => [
                'orderDiscounts' => false,
                'productDiscounts' => false,
                'shippingDiscounts' => false,
            ],
            'customerGets' => [
                'appliesOnOneTimePurchase' => true,
                'items' => [
                    'all' => true,
                ],
                'value' => $this->getDiscountValue(),
            ],
            'customerSelections' => $this->getCustomerSelections($customer),
            'endsAt' => now()->addSeconds($this->time_limit)->toISOString(),
            'startsAt' => now()->toISOString(),
            'title' => uniqid(),
            'usageLimit' => 1,
        ];
    }

    /**
     * Generate unique id for discount code
     *
     * @return string
     */
    public function generateDiscountCode()
    {
        return uniqid();
    }
}
