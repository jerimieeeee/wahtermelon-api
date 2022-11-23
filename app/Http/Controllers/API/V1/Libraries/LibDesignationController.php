<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibDesignationResource;
use App\Models\V1\Libraries\LibDesignation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for User Information
 *
 * APIs for managing libraries
 * @subgroup Designation
 * @subgroupDescription List of designation.
 */
class LibDesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort the code of Designation. Add hyphen (-) to descend the list: e.g. -code. Example: code
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibDesignationResource
     * @apiResourceModel App\Models\V1\Libraries\LibDesignation
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $query = QueryBuilder::for(LibDesignation::class)
            ->defaultSort('code')
            ->allowedSorts('code');
        return LibDesignationResource::collection($query->get());
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
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibDesignationResource
     * @apiResourceModel App\Models\V1\Libraries\LibDesignation
     * @param LibDesignation $designation
     * @return LibDesignationResource
     */
    public function show(LibDesignation $designation)
    {
        $query = LibDesignation::where('code', $designation->code);
        $designation = QueryBuilder::for($query)
            ->first();
        return new LibDesignationResource($designation);
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
