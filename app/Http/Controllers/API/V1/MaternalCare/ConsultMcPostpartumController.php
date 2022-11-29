<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\ConsultMcPostpartumRequest;
use App\Http\Resources\API\V1\MaternalCare\ConsultMcPostpartumResource;
use App\Models\V1\MaternalCare\ConsultMcPostpartum;
use App\Services\MaternalCare\MaternalCareRecordService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @authenticated
 * @group Maternal Care Management
 *
 * APIs for managing maternal care information
 * @subgroup Postpartum Visit
 * @subgroupDescription Postpartum visit management.
 */
class ConsultMcPostpartumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsultMcPostpartumRequest $request)
    {
        ConsultMcPostpartum::updateOrCreate(['patient_mc_id' => $request->patient_mc_id, 'postpartum_date' => $request->postpartum_date], $request->validatedWithCasts());
        $mc = new MaternalCareRecordService();
        return ConsultMcPostpartumResource::collection($mc->updateVisitSequence($request->patient_mc_id, 'ConsultMcPostpartum', 'postpartum_date'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConsultMcPostpartum $mcPostpartum
     * @return ConsultMcPostpartumResource
     */
    public function show(ConsultMcPostpartum $mcPostpartum): ConsultMcPostpartumResource
    {
        return new ConsultMcPostpartumResource($mcPostpartum);
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
