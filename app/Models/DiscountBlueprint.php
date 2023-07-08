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
                        'onwerId' => $owner_id,
                        'type' => 'json',
                        'namespace' => config('app.custom.metafield.prize_namespace'),
                        'key' => $this->getMetafieldKey(),
                        'value' => json_encode($this->only($this->fillable)),
                    ],
                ],
            );
        }
    }

    public function getMetafieldKey()
    {
        return sprintf("%0" . self::METAFIELD_KEY_LENGTH . "d", $this->id);
    }
}
