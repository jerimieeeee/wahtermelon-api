<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvGeneralSurveyResource;
use App\Models\V1\Libraries\LibGbvGeneralSurvey;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for GBV General Survey
 *
 * APIs for managing libraries
 *
 * @subgroup GBV General Survey.
 *
 * @subgroupDescription List of GBV General Survey.
 */
class LibGbvGeneralSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGbvGeneralSurveyResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGbvGeneralSurvey
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvGeneralSurvey::class)
            ->defaultSort('sequence');

        return LibGbvGeneralSurveyResource::collection($query->get());
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
