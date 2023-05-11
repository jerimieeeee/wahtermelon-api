<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvChildBehaviorResource;
use App\Models\V1\Libraries\LibGbvChildBehavior;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for GBV
 *
 * APIs for managing libraries
 *
 * @subgroup GBV Child behavior.
 *
 * @subgroupDescription List of GBV Child behavior.
 */
class LibGbvChildBehaviorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGbvChildBehaviorResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGbvChildBehavior
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvChildBehavior::class);

        return LibGbvChildBehaviorResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
