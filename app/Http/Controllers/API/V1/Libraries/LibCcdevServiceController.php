<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibCcdevServiceResource;
use App\Models\V1\Libraries\LibCcdevService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Child Care Services
 *
 * APIs for managing libraries
 *
 * @subgroup Services
 *
 * @subgroupDescription List of Services.
 */
class LibCcdevServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibCcdevServiceResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibCcdevService
     */
    public function index(): ResourceCollection
    {
        return LibCcdevServiceResource::collection(LibCcdevService::orderBy('order_seq', 'ASC')->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibCcdevServiceResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibCcdevService
     */
    public function show(LibCcdevService $ccService): LibCcdevServiceResource
    {
        $query = LibCcdevService::where('service_id', $ccService->service_id);
        $ccService = QueryBuilder::for($query)
            ->first();

        return new LibCcdevServiceResource($ccService);
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
