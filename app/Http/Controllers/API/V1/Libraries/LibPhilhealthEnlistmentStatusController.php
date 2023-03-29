<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPhilhealthEnlistmentStatusResource;
use App\Models\V1\Libraries\LibPhilhealthEnlistmentStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Philhealth Information
 *
 * APIs for managing libraries
 *
 * @subgroup Philhealth Enlistment Statuses
 *
 * @subgroupDescription List of philhealth enlistment statuses.
 */
class LibPhilhealthEnlistmentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPhilhealthEnlistmentStatusResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthEnlistmentStatus
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibPhilhealthEnlistmentStatus::class);

        return LibPhilhealthEnlistmentStatusResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPhilhealthEnlistmentStatusResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthEnlistmentStatus
     *
     * @return LibPhilhealthEnlistmentStatusResource
     */
    public function show(LibPhilhealthEnlistmentStatus $enlistmentStatus)
    {
        $query = LibPhilhealthEnlistmentStatus::where('id', $enlistmentStatus->id);
        $enlistmentStatus = QueryBuilder::for($query)
            ->first();

        return new LibPhilhealthEnlistmentStatusResource($enlistmentStatus);
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
