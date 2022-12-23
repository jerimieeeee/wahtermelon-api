<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\ConsultNcdRiskScreeningBloodLipidRequest;
use App\Http\Resources\API\V1\NCD\ConsultNcdRiskScreeningBloodLipidResource;
use App\Models\V1\NCD\ConsultNcdRiskScreeningBloodLipid;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Non-Communicable Disease Management
 *
 * APIs for managing Non-Communicable Disease information
 * @subgroup Risk Screening Blood Lipid
 * @subgroupDescription Risk Screening Blood Lipid management.
 */
class ConsultNcdRiskScreeningBloodLipidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_ncd_id string Patient record to view.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ConsultNcdRiskScreeningBloodLipid::query();
        $consultNcdRiskBloodLipid = QueryBuilder::for($query)
            ->when(isset($request->consult_ncd_risk_id), function ($q) use($request){
                $q->whereConsultNcdRiskId($request->consult_ncd_risk_id);
            })
            ->get();
        return ConsultNcdRiskScreeningBloodLipidResource::collection($consultNcdRiskBloodLipid);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultNcdRiskScreeningBloodLipidRequest $request
     * @return Response
     */
    public function store(ConsultNcdRiskScreeningBloodLipidRequest $request)
    {
        $data = ConsultNcdRiskScreeningBloodLipid::updateOrCreate($request->all());

        return new ConsultNcdRiskScreeningBloodLipidResource($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultNcdRiskScreeningBloodLipidRequest $request, $id)
    {
        $data = ConsultNcdRiskScreeningBloodLipid::findorfail($id)->update($request->all());

        return ConsultNcdRiskScreeningBloodLipidResource::collection($data);
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
