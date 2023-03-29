<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryFindingsResource;
use App\Models\V1\Libraries\LibLaboratoryFindings;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Findings
 *
 * @subgroupDescription List of laboratory findings.
 */
class LibLaboratoryFindingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryFindingsResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryFindings
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryFindings::class);

        return LibLaboratoryFindingsResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryFindingsResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryFindings
     */
    public function show(LibLaboratoryFindings $findings): LibLaboratoryFindingsResource
    {
        $query = LibLaboratoryFindings::where('code', $findings->code);
        $findings = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryFindingsResource($findings);
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
