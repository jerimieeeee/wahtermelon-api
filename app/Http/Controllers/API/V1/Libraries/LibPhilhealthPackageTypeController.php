<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPhilhealthMembershipTypeResource;
use App\Http\Resources\API\V1\Libraries\LibPhilhealthPackageTypeResource;
use App\Models\V1\Libraries\LibPhilhealthMembershipType;
use App\Models\V1\Libraries\LibPhilhealthPackageType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Philhealth Information
 *
 * APIs for managing libraries
 * @subgroup Philhealth Package Types
 * @subgroupDescription List of philhealth package types.
 */
class LibPhilhealthPackageTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPhilhealthPackageTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthPackageType
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibPhilhealthPackageType::class);
        return LibPhilhealthPackageTypeResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPhilhealthPackageTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthPackageType
     * @param LibPhilhealthPackageType $packageType
     * @return LibPhilhealthPackageTypeResource
     */
    public function show(LibPhilhealthPackageType $packageType)
    {
        $query = LibPhilhealthPackageType::where('id', $packageType->id);
        $packageType = QueryBuilder::for($query)
            ->first();
        return new LibPhilhealthPackageTypeResource($packageType);
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
