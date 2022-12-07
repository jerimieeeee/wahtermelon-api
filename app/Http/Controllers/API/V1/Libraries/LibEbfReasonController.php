<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibEbfReasonResource;
use App\Models\V1\Libraries\LibEbfReason;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Libraries for EBF Reasons
 *
 * APIs for managing libraries
 * @subgroup EBF Reasons
 * @subgroupDescription List of EBF Reasons.
 */
class LibEbfReasonController extends Controller
{
    /**
     * Display a listing of the EBF Reasons resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibEbfReasonResource
     * @apiResourceModel App\Models\V1\Libraries\LibEbfReason
     * @return ResourceCollection
     */
    public function index()
    {
        return LibEbfReasonResource::collection(LibEbfReason::orderBy('reason_id', 'ASC')->get());
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
     * Display the specified EBF Reason resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibEbfReasonResource
     * @apiResourceModel App\Models\V1\Libraries\LibEbfReason
     * @param LibEbfReason $reason_id
     * @return LibEbfReasonResource
     */
    public function show(LibEbfReason $reason_id, string $id): JsonResource
    {
        return new LibEbfReasonResource($reason_id->findOrFail($id));
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
