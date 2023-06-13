<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopifyResourceIndexRequest extends FormRequest
{
    /**
     * Maximum resources should get from shopify per request
     */
    const MAXIMUM_RESOURCE_AMOUNT = 20;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'after' => 'nullable|string',
            'before' => 'nullable|string',
            'limit' => 'nullable|int|min:1|max:' . self::MAXIMUM_RESOURCE_AMOUNT,
        ];
    }

    /**
     * Get the validated data from the request, and add some fields
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function validated($key = null, $default = null)
    {
        $input = parent::validated($key, $default);
        $limit = Arr::get($input, 'limit', self::MAXIMUM_RESOURCE_AMOUNT);

        if (Arr::has($input, 'before')) {
            $input['last'] = intval($limit);
        } else {
            $input['first'] = intval($limit);
        }

        unset($input['limit']);

        return $input;
    }
}
