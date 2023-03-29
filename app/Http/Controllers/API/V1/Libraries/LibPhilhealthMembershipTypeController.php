<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPhilhealthMembershipTypeResource;
use App\Models\V1\Libraries\LibPhilhealthMembershipType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Philhealth Information
 *
 * APIs for managing libraries
 *
 * @subgroup Philhealth Membership Types
 *
 * @subgroupDescription List of philhealth membership types.
 */
class LibPhilhealthMembershipTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPhilhealthMembershipTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthMembershipType
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibPhilhealthMembershipType::class);

        return LibPhilhealthMembershipTypeResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPhilhealthMembershipTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthMembershipType
     */
    public function show(LibPhilhealthMembershipType $membershipType): LibPhilhealthMembershipTypeResource
    {
        $query = LibPhilhealthMembershipType::where('id', $membershipType->id);
        $membershipType = QueryBuilder::for($query)
            ->first();

        return new LibPhilhealthMembershipTypeResource($membershipType);
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
