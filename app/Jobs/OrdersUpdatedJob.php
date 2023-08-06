<?php

namespace App\Jobs;

use App\Enums\LoyaltyRuleApplicationType;
use App\Enums\LoyaltyRuleStatus;
use App\Models\User;
use App\Models\Discount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use Osiset\ShopifyApp\Contracts\Queries\Shop as IShopQuery;
use stdClass;
use Carbon\Carbon;

class OrdersUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The shop domain.
     *
     * @var ShopDomain|string
     */
    protected $domain;

    /**
     * The webhook data.
     *
     * @var object
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param string   $domain The shop domain.
     * @param stdClass $data   The webhook data (JSON decoded).
     *
     * @return void
     */
    public function __construct(string $domain, stdClass $data)
    {
        $this->domain = $domain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(IShopQuery $shopQuery): void
    {
        // Convert the domain
        $this->domain = ShopDomain::fromNative($this->domain);
        $user = $shopQuery->getByDomain($this->domain);

        if (!$user) {
            return;
        }

        $shopify_id = data_get($this->data, 'id');
        $discount_applications = data_get($this->data, 'discount_applications', []);
        $order = $user->orders()->where('shopify_id', $shopify_id)->first();

        if ($order) {
            return;
        }

        $customer_data = data_get($this->data, 'customer');
        $customer_shopify_id = data_get($customer_data, 'id');
        $customer_email = data_get($customer_data, 'email');

        $customer = $user->customers()
            ->where('shopify_id', $customer_shopify_id)
            ->where('email', $customer_email)
            ->first();

        if (!$customer) {
            $customer = $user->customers()->create([
                'shopify_id' => $customer_shopify_id,
                'email' => $customer_email,
                'first_name' => data_get($customer_data, 'first_name'),
                'last_name' => data_get($customer_data, 'last_name'),
                'phone' => data_get($customer_data, 'phone'),
            ]);
        } else {
            foreach ($discount_applications as $discount) {
                $code = data_get($discount, 'code');
                $customer_discount = Discount::where('code', $code)
                    ->whereNull('used_at')
                    ->first();
                if ($customer_discount) {
                    $customer_discount->update([
                        'used_at' => new Carbon(data_get($this->data, 'processed_at')),
                    ]);
                }
            }
        }

        $line_items_data = data_get($this->data, 'line_items');
        $loyalty_point = 0;
        foreach ($line_items_data as $line_item) {
            $line_item_data = (array) $line_item;
            $point = $this->getLoyaltyPointByLineItem($user, $line_item_data);
            $loyalty_point += $point;
        }

        $customer->increment('loyalty_point', $loyalty_point);

        $user->orders()->create([
            'shopify_id' => $shopify_id,
            'customer_id' => $customer->id,
            'rewarded_point' => $loyalty_point,
            'token' => data_get($this->data, 'token'),
            'processed_at' => data_get($this->data, 'processed_at'),
        ]);
    }

    /**
     * Get loyalty point gained by line item
     *
     * @param \App\Models\User $user
     * @param array $line_item
     *
     * @return int
     */
    protected function getLoyaltyPointByLineItem(User $user, array $line_item)
    {
        $properties = data_get($line_item, 'properties');
        foreach ($properties as $property) {
            if (data_get($property, 'name') == '_loyalObjectId') {
                $loyaltyRule = $user->loyaltyRules()
                    ->where('status', LoyaltyRuleStatus::Published)
                    ->where('shopify_id', data_get($property, 'value'))
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$loyaltyRule) {
                    return 0;
                }

                return $loyaltyRule->loyalty_point;
            }
        }
        return 0;
    }
}
