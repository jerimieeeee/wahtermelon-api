<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryRequestStatusResource;
use App\Models\V1\Libraries\LibLaboratoryRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Request Statuses
 *
 * @subgroupDescription List of laboratory request statuses.
 */
class LibLaboratoryRequestStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort the sequence of Occupations. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryRequestStatusResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryRequestStatus
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $query = QueryBuilder::for(LibLaboratoryRequestStatus::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibLaboratoryRequestStatusResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryRequestStatusResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryRequestStatus
     */
    public function show(LibLaboratoryRequestStatus $status): LibLaboratoryRequestStatusResource
    {
        $query = LibLaboratoryRequestStatus::where('code', $status->code);
        $status = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryRequestStatusResource($status);
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
