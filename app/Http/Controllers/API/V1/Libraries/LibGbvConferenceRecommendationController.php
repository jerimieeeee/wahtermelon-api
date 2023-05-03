<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGbvConferenceRecommendationResource;
use App\Models\V1\Libraries\LibGbvConferenceRecommendation;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
/**
 * @group libraries for GBV
 *
 * APIs for managing libraries
 *
 * @subgroup GBV Conference recommendation.
 *
 * @subgroupDescription List of GBV Conference recommendation.
 */
class LibGbvConferenceRecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGbvConferenceRecommendationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGbvConferenceRecommendation
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGbvConferenceRecommendation::class);

        return LibGbvConferenceRecommendationResource::collection($query->get());
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
