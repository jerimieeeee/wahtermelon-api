<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryChestxrayObservationResource;
use App\Models\V1\Libraries\LibLaboratoryChestxrayObservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Chest X-ray Observation
 *
 * @subgroupDescription List of laboratory chest x-ray observation.
 */
class LibLaboratoryChestxrayObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryChestxrayObservationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryChestxrayObservation
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryChestxrayObservation::class)
            ->whereLibraryStatus(1);

        return LibLaboratoryChestxrayObservationResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryChestxrayObservationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryChestxrayObservation
     */
    public function show(LibLaboratoryChestxrayObservation $observation): LibLaboratoryChestxrayObservationResource
    {
        $query = LibLaboratoryChestxrayObservation::where('code', $observation->code);
        $observation = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryChestxrayObservationResource($observation);
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
