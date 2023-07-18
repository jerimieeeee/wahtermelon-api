<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvSymptomsCorporalResource;
use App\Models\V1\Libraries\LibGbvSymptomsCorporal;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for GBV Symptoms
 *
 * APIs for managing libraries
 *
 * @subgroup GBV Symptoms Corporal.
 *
 * @subgroupDescription List of GBV Symptoms Corporal.
 */
class LibGbvSymptomsCorporalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGbvSymptomsCorporalResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGbvSymptomsCorporal
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvSymptomsCorporal::class)
            ->defaultSort('sequence');

        return LibGbvSymptomsCorporalResource::collection($query->get());
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
