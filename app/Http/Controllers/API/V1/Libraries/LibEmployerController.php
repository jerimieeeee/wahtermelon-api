<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibEmployerResource;
use App\Models\V1\Libraries\LibEmployer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for User Information
 *
 * APIs for managing libraries
 *
 * @subgroup Employer
 *
 * @subgroupDescription List of employer.
 */
class LibEmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort the code of Designation. Add hyphen (-) to descend the list: e.g. -code. Example: code
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibEmployerResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibEmployer
     */
    public function index(Request $request): ResourceCollection
    {
        $query = QueryBuilder::for(LibEmployer::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibEmployerResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibDesignationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibEmployer
     *
     * @return LibDesignationResource
     */
    public function show(LibEmployer $employer)
    {
        $query = LibEmployer::where('code', $employer->code);
        $employer = QueryBuilder::for($query)
            ->first();

        return new LibEmployerResource($employer);
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
