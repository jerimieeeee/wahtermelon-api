<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibComplaintResource;
use App\Models\V1\Libraries\LibComplaint;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Libraries for Consultation
 *
 * APIs for managing libraries
 * @subgroup Chief Complaints
 * @subgroupDescription List of chief complaints.
 */

class LibComplaintController extends Controller
{
    /**
     * Display a listing of the Chief Complaints resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibComplaintResource
     * @apiResourceModel App\Models\V1\Libraries\LibComplaint
     * @return ResourceCollection
     */

    public function index()
    {
        return LibComplaintResource::collection(LibComplaint::orderBy('complaint_id', 'ASC')->get());
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
     * Display the specified Chief Complaints resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibComplaintResource
     * @apiResourceModel App\Models\V1\Libraries\LibComplaint
     * @param LibComplaint $complaint_id
     * @return LibComplaintResource
     */

    public function show(LibComplaint $complaint_id, string $id): JsonResource
    {
        return new LibComplaintResource($complaint_id->findOrFail($id));
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
