<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPwdTypeResource;
use App\Models\V1\Libraries\LibPwdType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Personal Information
 *
 * APIs for managing libraries
 * @subgroup PWD Types
 * @subgroupDescription List of pwd types.
 */
class LibPwdTypeController extends Controller
{
    /**
     * Display a listing of the PWD Type resource.
     *
     * @queryParam sort string Sort the sequence of Occupations. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPwdTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibPwdType
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibPwdType::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');
        return LibPwdTypeResource::collection($query->get());
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
     * Display the specified PWD Type resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPwdTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibPwdType
     * @param LibPwdType $pwdType
     * @return LibPwdTypeResource
     */
    public function show(LibPwdType $pwdType): LibPwdTypeResource
    {
        $query = LibPwdType::where('code', $pwdType->code);
        $pwdType = QueryBuilder::for($query)
            ->first();
        return new LibPwdTypeResource($pwdType);
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
