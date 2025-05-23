<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvSymptomsBehavioralResource;
use App\Models\V1\Libraries\LibGbvSymptomsBehavioral;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for GBV Symptoms
 *
 * APIs for managing libraries
 *
 * @subgroup GBV Symptoms Behavioral.
 *
 * @subgroupDescription List of GBV Symptoms Behavioral.
 */
class LibGbvSymptomsBehavioralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGbvSymptomsBehavioralResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGbvSymptomsBehavioral
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvSymptomsBehavioral::class)
            ->defaultSort('sequence');

        return LibGbvSymptomsBehavioralResource::collection($query->get());
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
