<?php

namespace App\Models;

use App\Enums\ProductStatus;
use App\Enums\ShopifyType;
use App\Services\Shopify\Graphql\MetafieldService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'shopify_id',
        'title',
        'loyalty_point',
        'image_src',
        'status',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'status' => ProductStatus::class,
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
            $query->where('title', 'ILIKE', "%{$input['query']}%");
        }

        if (isset($input['status'])) {
            $query->where('status', $input['status']);
        }

        $query->orderBy($input['order_by'], $input['sort']);
        return $query;
    }

    /**
     * Sync product loyalty data to shopify
     */
    public function syncMetafield()
    {
        try {
            $metafield_service = App::make(MetafieldService::class);
            return $metafield_service->updateMetafields($this->getMetafieldData());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }

    /**
     * Get metafield data
     * @return array|null
     */
    public function getMetafieldData()
    {
        $owner_id = $this->getShopifyGraphqlId();
        if (!$owner_id) {
            return null;
        }
        return [
            [
                'ownerId' => $owner_id,
                'type' => 'json',
                'namespace' => config('app.custom.metafield.namespace'),
                'key' => config('app.custom.metafield.key'),
                'value' => json_encode($this->toShopify()),
            ],
        ];
    }

    /**
     * Create metafield value to shopify
     */
    public function toShopify()
    {
        return [
            'id' => $this->id,
            'loyalty_point' => $this->loyalty_point,
        ];
    }

    /**
     * Get product shopify graphql id
     * @return string|null
     */
    public function getShopifyGraphqlId()
    {
        if (!$this->shopify_id) {
            return null;
        }

        return 'gid://shopify/' . ShopifyType::Product->value . '/' . $this->shopify_id;
    }
}
