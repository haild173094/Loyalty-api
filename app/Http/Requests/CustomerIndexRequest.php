<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CustomerIndexRequest extends FormRequest
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
            'order_by' => [
                'nullable',
                Rule::in(['created_at', 'updated_at', 'id']),
            ],
            'query' => 'string|nullable',
            'sort' => [
                'nullable',
                Rule::in(['desc', 'asc']),
            ],
            'page' => 'string|nullable',
            'limit' => 'integer|nullable',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validated($key = null, $default = null)
    {
        $input = parent::validated();

        if (!isset($input['order_by'])) {
            $input['order_by'] = 'id';
        }

        if (!isset($input['sort'])) {
            $input['sort'] = 'desc';
        }

        if (!isset($input['limit']) || $input['limit'] > 20) {
            $input['limit'] = 20;
        }

        if (!isset($input['page'])) {
            $input['page'] = null;
        }

        return data_get($input, $key, $default);
    }
}
