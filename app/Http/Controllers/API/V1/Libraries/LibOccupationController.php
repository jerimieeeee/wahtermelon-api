<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibOccupationResource;
use App\Models\V1\Libraries\LibOccupation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Personal Information
 *
 * APIs for managing libraries
 * @subgroup Occupations
 * @subgroupDescription List of occupations.
 */
class LibOccupationController extends Controller
{
    /**
     * Display a listing of the Occupation resource.
     *
     * @queryParam sort string Sort the occupation_desc of Occupations. Add hyphen (-) to descend the list: e.g. -occupation_desc. Example: occupation_desc
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibOccupationResource
     * @apiResourceModel App\Models\V1\Libraries\LibOccupation
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibOccupation::class)
            ->defaultSort('occupation_desc')
            ->allowedSorts('occupation_desc');
        return LibOccupationResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Occupation resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibOccupationResource
     * @apiResourceModel App\Models\V1\Libraries\LibOccupation
     * @param LibOccupation $occupation
     * @return LibOccupationResource
     */
    public function show(LibOccupation $occupation): LibOccupationResource
    {
        $query = LibOccupation::where('code', $occupation->code);
        $occupation = QueryBuilder::for($query)
            ->first();
        return new LibOccupationResource($occupation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
