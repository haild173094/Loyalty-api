<?php

namespace App\Http\Controllers\API\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CustomerGetRequest;
use App\Models\User;
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
        $user = User::where('name', $input['shop'])->firstOrFail();
        return $user
            ->customers()
            ->where('shopify_id', $input['logged_in_customer_id'])
            ->first();
    }
}
