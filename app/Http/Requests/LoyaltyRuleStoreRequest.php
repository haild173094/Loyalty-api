<?php

namespace App\Http\Requests;

use App\Enums\LoyaltyRuleApplicationType;
use App\Enums\LoyaltyRuleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class LoyaltyRuleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'shopify_id' => 'string|required',
            'type' => [
                'required',
                new Enum(LoyaltyRuleApplicationType::class),
            ],
            'loyalty_point' => 'integer|required|min:0',
        ];
    }
}
