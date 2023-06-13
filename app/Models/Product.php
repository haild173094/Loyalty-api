<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
