<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryRecommendationResource;
use App\Models\V1\Libraries\LibLaboratoryRecommendation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Recommendations
 *
 * @subgroupDescription List of laboratory recommendations.
 */
class LibLaboratoryRecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort the sequence of Occupations. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryRecommendationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryRecommendation
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryRecommendation::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibLaboratoryRecommendationResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryRecommendationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryRecommendation
     */
    public function show(LibLaboratoryRecommendation $recommendation): LibLaboratoryRecommendationResource
    {
        $query = LibLaboratoryRecommendation::where('code', $recommendation->code);
        $recommendation = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryRecommendationResource($recommendation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
