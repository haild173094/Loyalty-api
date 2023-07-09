<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    /**
     * Show user data
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Http\Resources\UserResource
     */
    public function show(Request $request)
    {
        return new UserResource(Auth::user());
    }
}
