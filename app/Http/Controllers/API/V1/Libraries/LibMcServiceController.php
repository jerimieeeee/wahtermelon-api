<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMcServiceResource;
use App\Models\V1\Libraries\LibMcService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Maternal Care
 *
 * APIs for managing libraries
 * @subgroup Services
 * @subgroupDescription List of Services.
 */
class LibMcServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMcServiceResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcService
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMcService::class);
        return LibMcServiceResource::collection($query->get());
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
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMcServiceResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcService
     * @param LibMcService $mcService
     * @return LibMcServiceResource
     */
    public function show(LibMcService $mcService): LibMcServiceResource
    {
        $query = LibMcService::where('id', $mcService->id);
        $mcService = QueryBuilder::for($query)
            ->first();
        return new LibMcServiceResource($mcService);
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
