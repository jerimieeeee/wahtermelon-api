<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibReligionResource;
use App\Models\V1\Libraries\LibReligion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Personal Information
 *
 * APIs for managing libraries
 * @subgroup Religions
 * @subgroupDescription List of religions.
 */
class LibReligionController extends Controller
{
    /**
     * Display a listing of the Religion resource.
     *
     * @queryParam sort string Sort the religion_desc of Occupations. Add hyphen (-) to descend the list: e.g. -religion_desc. Example: religion_desc
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibReligionResource
     * @apiResourceModel App\Models\V1\Libraries\LibReligion
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibReligion::class)
            ->defaultSort('religion_desc')
            ->allowedSorts('religion_desc');
        return LibReligionResource::collection($query->get());
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
     * Display the specified Religion resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibReligionResource
     * @apiResourceModel App\Models\V1\Libraries\LibReligion
     * @param LibReligion $religion
     * @return LibReligionResource
     */
    public function show(LibReligion $religion): LibReligionResource
    {
        $query = LibReligion::where('code', $religion->code);
        $religion = QueryBuilder::for($query)
            ->first();
        return new LibReligionResource($religion);
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
