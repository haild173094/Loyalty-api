<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class ShopifyProductIndexRequest extends ShopifyResourceIndexRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'title' => 'nullable|string',
            'locale' => 'nullable|string',
            'status' => [
                'nullable',
                Rule::in([
                    'ACTIVE',
                    'ARCHIVED',
                    'DRAFT'
                ])
            ],
        ]);
    }

    /**
     * Get the validated data from the request.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function validated($key = null, $default = null)
    {
        $input = parent::validated($key, $default);

        $query = [];

        if ($limit = Arr::get($input, 'limit')) {
            if (Arr::has($input, 'before')) {
                $input['last'] = intval($limit);
            } else {
                $input['first'] = intval($limit);
            }
        }

        if ($title = Arr::get($input, 'title')) {
            $query[] = "title:*$title*";
            unset($input['title']);
        }

        if ($status = Arr::get($input, 'status')) {
            $query[] = "status:$status";
            unset($input['status']);
        }

        if (!empty($query)) {
            $input['query'] = implode(' ', $query);
        }

        return $input;
    }
}
