<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryChestxrayFindingsResource;
use App\Models\V1\Libraries\LibLaboratoryChestxrayFindings;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Chest X-ray Findings
 *
 * @subgroupDescription List of laboratory chest x-ray findings.
 */
class LibLaboratoryChestxrayFindingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryChestxrayFindingsResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryChestxrayFindings
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryChestxrayFindings::class)
            ->whereLibraryStatus(1);

        return LibLaboratoryChestxrayFindingsResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryChestxrayFindingsResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryChestxrayFindings
     */
    public function show(LibLaboratoryChestxrayFindings $findings): LibLaboratoryChestxrayFindingsResource
    {
        $query = LibLaboratoryChestxrayFindings::where('code', $findings->code);
        $findings = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryChestxrayFindingsResource($findings);
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
