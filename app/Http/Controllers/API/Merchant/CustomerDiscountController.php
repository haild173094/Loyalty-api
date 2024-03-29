<?php

namespace App\Http\Controllers\API\Merchant;

use App\Enums\DiscountBlueprintStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CustomerDiscountIndexRequest;
use App\Http\Requests\Merchant\CustomerDiscountRedeemRequest;
use App\Services\Shopify\Graphql\DiscountService;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerDiscountController extends Controller
{
    /**
     * Get list of customer's discounts
     *
     * @param \App\Http\Requests\Merchant\CustomerDiscountIndexRequest
     */
    public function index(CustomerDiscountIndexRequest $request)
    {
        $input = $request->validated();
        $customer = auth()->user()->customers()->where('shopify_id', $input['logged_in_customer_id'])->firstOrFail();
        return $customer->discounts;
    }

    /**
     * Exchange discount code
     *
     * @param \App\Http\Requests\Merchant\CustomerDiscountRedeemRequest $request
     * @param \App\Services\Shopify\Graphql\DiscountService $discount_service
     *
     * @return \App\Models\Discount
     */
    public function redeem(CustomerDiscountRedeemRequest $request)
    {
        $input = $request->validated();
        $user = User::where('name', $input['shop'])->firstOrFail();
        $customer = $user->customers()->where('shopify_id', $input['logged_in_customer_id'])->firstOrFail();
        $discount_service = new DiscountService($user);
        $discount_blueprint = $user->discountBlueprints()
            ->where('id', $input['discount_blueprint_id'])
            ->where('status', DiscountBlueprintStatus::Published)
            ->firstOrFail();

        if ($discount_blueprint->loyalty_price > $customer->loyalty_point) {
            abort(400, "Not enough point");
        }

        $code_discount = $discount_service->createBasicDiscount($discount_blueprint->toShopify($customer));

        if (!$code_discount) {
            abort(500, 'Somethings went wrong, can not redeem');
        }

        $code = data_get($code_discount, 'codes.nodes.0.code');
        $starts_at = data_get($code_discount, 'startsAt');
        $ends_at = data_get($code_discount, 'endsAt');

        $discount = $customer->discounts()->create([
            'user_id' => $user->id,
            'discount_blueprint_id' => $discount_blueprint->id,
            'code' => $code,
            'starts_at' => $starts_at,
            'ends_at' => $ends_at,
            'customer_selection' => $discount_blueprint->customer_selection,
            'type' => $discount_blueprint->type,
            'amount' => $discount_blueprint->amount,
            'description' => $discount_blueprint->description,
        ]);

        $customer->decrement('loyalty_point', $discount_blueprint->loyalty_price);

        return $discount;
    }
}
