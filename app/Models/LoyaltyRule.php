<?php

namespace App\Models;

use App\Enums\LoyaltyRuleApplicationType;
use App\Enums\LoyaltyRuleStatus;
use App\Enums\ShopifyType;
use App\Services\Shopify\Graphql\MetafieldService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class LoyaltyRule extends Model
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
        'shopify_id',
        'loyalty_point',
        'type',
        'status',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'status' => LoyaltyRuleStatus::class,
        'type' => LoyaltyRuleApplicationType::class,
    ];

    /**
     * User own this product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for search
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param array $input
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $input)
    {
        if (isset($input['query'])) {
            $query->where('name', 'ILIKE', "%{$input['query']}%");
        }

        if (isset($input['status'])) {
            $query->where('status', $input['status']);
        }

        if (isset($input['type'])) {
            $query->where('type', $input['type']);
        }

        $query->orderBy($input['order_by'], $input['sort']);
        return $query;
    }

    /**
     * Sync discount blueprint data to shopify metafield
     */
    public function syncMetafield()
    {
        $metafield_service = App::make(MetafieldService::class, ['shop' => $this->user]);
        $owner_id = $this->user->getShopifyGraphqlId();

        if ($owner_id) {
            $result = $metafield_service->updateMetafields(
                [
                    'metafields' => [
                        [
                            'ownerId' => $owner_id,
                            'type' => 'json',
                            'namespace' => config('app.custom.metafield.rule_namespace'),
                            'key' => $this->getMetafieldKey(),
                            'value' => json_encode($this->only($this->fillable)),
                        ],
                    ],
                ],
            );

            $metafield_id = data_get($result, '0.id');

            if ($metafield_id) {
                $this->metafield_id = $metafield_id;
                $this->save();
            }
        }
    }

    public function getMetafieldKey()
    {
        return sprintf("%0" . self::METAFIELD_KEY_LENGTH . "d", $this->id);
    }

    /**
     * Delete option's associated metafield
     *
     * @return mixed
     */
    public function deleteAssociatedMetafield()
    {
        if (!$this->metafield_id) {
            return;
        }
        $user = $this->user;
        $metafield_service = App::make(MetafieldService::class, ['shop' => $user]);
        return $metafield_service->deleteMetafield([
            'input' => [
                'id' => $this->metafield_id,
            ],
        ]);
    }
}
