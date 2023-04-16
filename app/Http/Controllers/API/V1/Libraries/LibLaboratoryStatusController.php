<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryStatusResource;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Statuses
 *
 * @subgroupDescription List of laboratory statuses.
 */
class LibLaboratoryStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort the sequence of Occupations. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryStatusResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryStatus
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryStatus::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibLaboratoryStatusResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryStatusResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryStatus
     */
    public function show(LibLaboratoryStatus $laboratoryStatus): LibLaboratoryStatusResource
    {
        $query = LibLaboratoryStatus::where('code', $laboratoryStatus->code);
        $laboratoryStatus = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryStatusResource($laboratoryStatus);
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
