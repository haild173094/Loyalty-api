<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'shopify_id',
        'loyalty_point',
    ];

    /**
     * User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Discounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discounts()
    {
        return $this->hasMany(Discount::class);
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
            $query->where(function ($query) use ($input) {
                $query->where('first_name', 'ILIKE', "%{$input['query']}%")
                    ->orWhere('last_name', 'ILIKE', "%{$input['query']}%")
                    ->orWhere('email', 'ILIKE', "%{$input['query']}%")
                    ->orWhere('phone', 'ILIKE', "%{$input['query']}%");
            });
        }

        $query->orderBy($input['order_by'], $input['sort']);
        return $query;
    }
}
