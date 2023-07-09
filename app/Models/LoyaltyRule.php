<?php

namespace App\Models;

use App\Enums\LoyaltyRuleStatus;
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

        $query->orderBy($input['order_by'], $input['sort']);
        return $query;
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
                        'namespace' => config('app.custom.metafield.rule_namespace'),
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
