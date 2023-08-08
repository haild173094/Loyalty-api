<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->only([
            'name',
            'email',
            "shop_id",
            "shop_name",
            "shop_email",
            "domain",
            "province",
            "country",
            "address1",
            "zip",
            "city",
            "source",
            "phone",
            "latitude",
            "longitude",
            "primary_locale",
            "address2",
            "shop_created_at",
            "shop_updated_at",
            "country_code",
            "country_name",
            "currency",
            "customer_email",
            "timezone",
            "iana_timezone",
            "shop_owner",
            "money_format",
            "money_with_currency_format",
            "weight_unit",
            "province_code",
            "taxes_included",
            "auto_configure_tax_inclusivity",
            "tax_shipping",
            "county_taxes",
            "plan_display_name",
            "plan_name",
            "has_discounts",
            "has_gift_cards",
            "myshopify_domain",
            "google_apps_domain",
            "google_apps_login_enabled",
            "money_in_emails_format",
            "money_with_currency_in_emails_format",
            "eligible_for_payments",
            "requires_extra_payments_agreement",
            "password_enabled",
            "has_storefront",
            "cookie_consent_level",
            "visitor_tracking_consent_preference",
            "checkout_api_supported",
            "multi_location_enabled",
            "setup_required",
            "pre_launch_enabled",
            "enabled_presentment_currencies",
            "transactional_sms_disabled",
            "marketing_sms_consent_enabled_at_checkout"
        ]);
    }
}
