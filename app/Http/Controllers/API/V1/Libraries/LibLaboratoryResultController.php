<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryResultResource;
use App\Models\V1\Libraries\LibLaboratoryResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Results
 *
 * @subgroupDescription List of laboratory results.
 */
class LibLaboratoryResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryResultResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryResult
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryResult::class);

        return LibLaboratoryResultResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryResultResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryResult
     */
    public function show(LibLaboratoryResult $result): LibLaboratoryResultResource
    {
        $query = LibLaboratoryResult::where('code', $result->code);
        $result = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryResultResource($result);
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
