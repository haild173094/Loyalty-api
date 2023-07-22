<?php

namespace App\Http\Controllers\API\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CustomerGetRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param \App\Http\Requests\Merchant\CustomerGetRequest $request
     *
     * @return \App\Models\Customer
     */
    public function show(CustomerGetRequest $request)
    {
        $input = $request->validated();
        return auth()->user()
            ->customers()
            ->where('shopify_id', $input['logged_in_customer_id'])
            ->first();
    }
}
