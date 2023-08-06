<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DiscountApplicationType;
use App\Enums\DiscountType;
use App\Models\User;
use App\Models\DiscountBlueprint;
use App\Models\Customer;

class Discount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'discount_blueprint_id',
        'code',
        'amount',
        'description',
        'type',
        'customer_selection',
        'starts_at',
        'ends_at',
        'used_at',
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
