<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibCivilStatusResource;
use App\Models\V1\Libraries\LibCivilStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Personal Information
 *
 * APIs for managing libraries
 *
 * @subgroup Civil Statuses
 *
 * @subgroupDescription List of civil statuses.
 */
class LibCivilStatusController extends Controller
{
    /**
     * Display a listing of the Civil Status resource.
     *
     * @queryParam sort string Sort the code of Civil Statuses. Add hyphen (-) to descend the list: e.g. -code. Example: code
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibCivilStatusResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibCivilStatus
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibCivilStatus::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibCivilStatusResource::collection($query->get());
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
     * Display the specified Civil Status resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibCivilStatusResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibCivilStatus
     */
    public function show(LibCivilStatus $civilStatus): LibCivilStatusResource
    {
        $query = LibCivilStatus::where('code', $civilStatus->code);
        $civilStatus = QueryBuilder::for($query)
            ->first();

        return new LibCivilStatusResource($civilStatus);
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
