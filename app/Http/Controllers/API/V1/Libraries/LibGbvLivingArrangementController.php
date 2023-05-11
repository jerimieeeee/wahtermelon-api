<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvLivingArrangementResource;
use App\Models\V1\Libraries\LibGbvLivingArrangement;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for GBV
 *
 * APIs for managing libraries
 *
 * @subgroup GBV living arrangement.
 *
 * @subgroupDescription List of GBV living arrangement.
 */
class LibGbvLivingArrangementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGbvLivingArrangementResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGbvLivingArrangment
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvLivingArrangement::class);

        return LibGbvLivingArrangementResource::collection($query->get());
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
