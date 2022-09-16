<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibBloodTypeResource;
use App\Models\V1\Libraries\LibBloodType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Personal Information
 *
 * APIs for managing libraries
 * @subgroup Blood Types
 * @subgroupDescription List of blood types.
 */
class LibBloodTypeController extends Controller
{
    /**
     * Display a listing of the Blood Type resource.
     *
     * @queryParam sort string Sort the sequence of blood types. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibBloodTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibBloodType
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibBloodType::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');
        return LibBloodTypeResource::collection($query->get());
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
     * Display the specified Blood Type resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibBloodTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibBloodType
     * @param LibBloodType $bloodType
     * @return LibBloodTypeResource
     */
    public function show(LibBloodType $bloodType): LibBloodTypeResource
    {
        $query = LibBloodType::where('code', $bloodType->code);
        $bloodType = QueryBuilder::for($query)
            ->first();
        return new LibBloodTypeResource($bloodType);
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
