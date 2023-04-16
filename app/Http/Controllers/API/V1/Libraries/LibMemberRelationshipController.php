<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMemberRelationshipResource;
use App\Models\V1\Libraries\LibMemberRelationship;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Philhealth Information
 *
 * APIs for managing libraries
 *
 * @subgroup Philhealth Member Relationships
 *
 * @subgroupDescription List of philhealth member relationships.
 */
class LibMemberRelationshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMemberRelationshipResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMemberRelationship
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMemberRelationship::class);

        return LibMemberRelationshipResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMemberRelationshipResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMemberRelationship
     *
     * @return LibMemberRelationshipResource
     */
    public function show(LibMemberRelationship $memberRelationship)
    {
        $query = LibMemberRelationship::where('id', $memberRelationship->id);
        $memberRelationship = QueryBuilder::for($query)
            ->first();

        return new LibMemberRelationshipResource($memberRelationship);
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
