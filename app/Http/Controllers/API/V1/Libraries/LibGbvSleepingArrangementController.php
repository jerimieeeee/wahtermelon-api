<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvSleepingArrangementResource;
use App\Models\V1\Libraries\LibGbvSleepingArrangement;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
/**
 * @group libraries for GBV
 *
 * APIs for managing libraries
 *
 * @subgroup GBV Sleeping arrangement.
 *
 * @subgroupDescription List of GBV Sleeping arrangement.
 */
class LibGbvSleepingArrangementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection
     *
     * @apiResourceModel
     *
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvSleepingArrangement::class);

        return LibGbvSleepingArrangementResource::collection($query->get());
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
