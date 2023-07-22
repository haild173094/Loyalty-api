<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountBlueprintIndexRequest;
use App\Http\Requests\DiscountBlueprintStoreRequest;
use App\Http\Requests\DiscountBlueprintUpdateRequest;
use App\Models\DiscountBlueprint;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiscountBlueprintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DiscountBlueprintIndexRequest $request)
    {
        $input = $request->validated();
        return auth()
            ->user()
            ->products()
            ->search($input)
            ->paginate($input['limit'], '[*]', 'page', $input['page']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountBlueprintStoreRequest $request)
    {
        $input = $request->validated();
        $discount_blueprint = Auth::user()->products()->create($input);
        $discount_blueprint->syncMetafield();
        return $discount_blueprint;
    }

    /**
     * Display the specified resource.
     */
    public function show(DiscountBlueprint $discountBlueprint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DiscountBlueprint $discountBlueprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountBlueprintUpdateRequest $request, DiscountBlueprint $discount_blueprint)
    {
        $discount_blueprint->update($request->validated());
        $discount_blueprint->syncMetafield();
        return $discount_blueprint;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiscountBlueprint $discount_blueprint)
    {
        $discount_blueprint->deleteAssociatedMetafield();
        $discount_blueprint->delete();
        return new Response('No content', 204);
    }
}
