<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPhilhealthMembershipCategoryResource;
use App\Models\V1\Libraries\LibPhilhealthMembershipCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Philhealth Information
 *
 * APIs for managing libraries
 *
 * @subgroup Philhealth Membership Categories
 *
 * @subgroupDescription List of philhealth membership categories.
 */
class LibPhilhealthMembershipCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPhilhealthMembershipCategoryResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthMembershipCategory
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibPhilhealthMembershipCategory::class);

        return LibPhilhealthMembershipCategoryResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPhilhealthMembershipCategoryResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthMembershipCategory
     */
    public function show(LibPhilhealthMembershipCategory $membershipCategory): LibPhilhealthMembershipCategoryResource
    {
        $query = LibPhilhealthMembershipCategory::where('id', $membershipCategory->id);
        $membershipCategory = QueryBuilder::for($query)
            ->first();

        return new LibPhilhealthMembershipCategoryResource($membershipCategory);
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
