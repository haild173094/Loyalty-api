<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'amount',
        'type',
        'customer_selection',
        'starts_at',
        'ends_at',
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
     * Belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs to discount blueprint
     */
    public function discountBlueprint()
    {
        return $this->belongsTo(DiscountBlueprint::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
