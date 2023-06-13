<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvSymptomsAnogenitalResource;
use App\Http\Resources\API\V1\Libraries\LibWashingtonDisabilityAnswerResource;
use App\Models\V1\Libraries\LibGbvSymptomsAnogenital;
use App\Models\V1\Libraries\LibWashingtonDisabilityAnswer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for GBV Symptoms
 *
 * APIs for managing libraries
 *
 * @subgroup GBV Symptoms Anogenital.
 *
 * @subgroupDescription List of GBV Symptoms Anogenital.
 */
class LibGbvSymptomsAnogenitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGbvSymptomsAnogenitalResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGbvSymptomsAnogenital
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvSymptomsAnogenital::class)
            ->defaultSort('sequence');

        return LibGbvSymptomsAnogenitalResource::collection($query->get());
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
