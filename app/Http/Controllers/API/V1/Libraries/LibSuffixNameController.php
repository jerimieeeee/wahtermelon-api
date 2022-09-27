<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibSuffixNameResource;
use App\Models\V1\Libraries\LibSuffixName;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Personal Information
 *
 * APIs for managing libraries
 * @subgroup Suffix Names
 * @subgroupDescription List of suffix names.
 */
class LibSuffixNameController extends Controller
{
    /**
     * Display a listing of the Suffix Name resource.
     *
     * @queryParam sort string Sort the sequence of Occupations. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibSuffixNameResource
     * @apiResourceModel App\Models\V1\Libraries\LibSuffixName
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibSuffixName::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');
        return LibSuffixNameResource::collection($query->get());
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
     * Display the specified Suffix Name resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibSuffixNameResource
     * @apiResourceModel App\Models\V1\Libraries\LibSuffixName
     * @param LibSuffixName $suffixName
     * @return LibSuffixNameResource
     */
    public function show(LibSuffixName $suffixName): LibSuffixNameResource
    {
        $query = LibSuffixName::where('code', $suffixName->code);
        $suffixName = QueryBuilder::for($query)
            ->first();
        return new LibSuffixNameResource($suffixName);
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
