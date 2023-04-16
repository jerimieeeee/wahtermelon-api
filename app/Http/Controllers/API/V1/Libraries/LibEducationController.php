<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibEducationResource;
use App\Models\V1\Libraries\LibEducation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Personal Information
 *
 * APIs for managing libraries
 *
 * @subgroup Education
 *
 * @subgroupDescription List of education.
 */
class LibEducationController extends Controller
{
    /**
     * Display a listing of the Education resource.
     *
     * @queryParam sort string Sort the code of Eduction. Add hyphen (-) to descend the list: e.g. -code. Example: code
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibEducationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibEducation
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibEducation::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibEducationResource::collection($query->get());
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
     * Display the specified Education resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibEducationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibEducation
     */
    public function show(LibEducation $education): LibEducationResource
    {
        $query = LibEducation::where('code', $education->code);
        $education = QueryBuilder::for($query)
            ->first();

        return new LibEducationResource($education);
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
