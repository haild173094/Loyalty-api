<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionIndexRequest;
use App\Http\Requests\CollectionStoreRequest;
use App\Http\Requests\CollectionUpdateRequest;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CollectionIndexRequest $request)
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
    public function create(CollectionStoreRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CollectionStoreRequest $request)
    {
        $input = $request->validated();
        return Auth::user()->collections()->create($input);
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CollectionUpdateRequest $request, Collection $collection)
    {
        return $collection->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        //
    }
}
