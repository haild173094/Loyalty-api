<?php

namespace App\Http\Requests;

use App\Enums\DiscountApplicationType;
use App\Enums\DiscountType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class DiscountBlueprintStoreRequest extends FormRequest
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
            'description' => 'string|nullable',
            'type' => [
                'required',
                new Enum(DiscountType::class),
            ],
            'amount' => 'numeric|required',
            'loyalty_price' => 'integer|required',
            'customer_selection' => [
                'required',
                new Enum(DiscountApplicationType::class),
            ],
            'time_limit' => 'integer|required',
        ];
    }
}
