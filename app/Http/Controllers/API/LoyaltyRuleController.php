<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoyaltyRuleIndexRequest;
use App\Http\Requests\LoyaltyRuleStoreRequest;
use App\Models\LoyaltyRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\LoyaltyRuleStatus;
use Illuminate\Http\Response;

class LoyaltyRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LoyaltyRuleIndexRequest $request)
    {
        $input = $request->validated();
        return auth()
            ->user()
            ->loyaltyRules()
            ->search($input)
            ->paginate($input['limit'], ['*'], 'page', $input['page']);
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
    public function store(LoyaltyRuleStoreRequest $request)
    {
        $input = $request->validated();
        $input['status'] = LoyaltyRuleStatus::Published;

        $loyalty_rule = Auth::user()->loyaltyRules()->create($input);

        $loyalty_rule->syncMetafield();
        return $loyalty_rule;
    }

    /**
     * Display the specified resource.
     */
    public function show(LoyaltyRule $loyaltyRule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoyaltyRule $loyaltyRule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoyaltyRule $loyalty_rule)
    {
        $loyalty_rule->update($request->validated());
        $loyalty_rule->syncMetafield();
        return $loyalty_rule;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoyaltyRule $loyalty_rule)
    {
        $loyalty_rule->deleteAssociatedMetafield();
        $loyalty_rule->delete();
        return new Response('No content', 204);
    }
}
