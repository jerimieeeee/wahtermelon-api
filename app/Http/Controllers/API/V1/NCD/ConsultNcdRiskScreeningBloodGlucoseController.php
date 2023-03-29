<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\ConsultNcdRiskScreeningBloodGlucoseRequest;
use App\Http\Resources\API\V1\NCD\ConsultNcdRiskScreeningBloodGlucoseResoure;
use App\Models\V1\NCD\ConsultNcdRiskScreeningBloodGlucose;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Non-Communicable Disease Management
 *
 * APIs for managing Non-Communicable Disease information
 *
 * @subgroup Risk Screening Blood Glucose
 *
 * @subgroupDescription Risk Screening Blood Glucose management.
 */
class ConsultNcdRiskScreeningBloodGlucoseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam consult_ncd_risk_id string Patient record to view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ConsultNcdRiskScreeningBloodGlucose::query();
        $consultNcdRiskBloodGlucose = QueryBuilder::for($query)
            ->when(isset($request->consult_ncd_risk_id), function ($q) use ($request) {
                $q->whereConsultNcdRiskId($request->consult_ncd_risk_id);
            })
            ->get();

        return ConsultNcdRiskScreeningBloodGlucoseResoure::collection($consultNcdRiskBloodGlucose);
    }

    /**
     * Store a newly created Consult Risk Screening Blood Glucose resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\NCD\ConsultNcdRiskScreeningBloodGlucoseResoure
     *
     * @apiResourceModel App\Models\V1\NCD\ConsultNcdRiskScreeningBloodGlucose
     *
     * @return JsonResponse
     */
    public function store(ConsultNcdRiskScreeningBloodGlucoseRequest $request)
    {
        $data = ConsultNcdRiskScreeningBloodGlucose::updateOrCreate(['consult_ncd_risk_id' => $request['consult_ncd_risk_id']], $request->validated());
        $data1 = new ConsultNcdRiskScreeningBloodGlucoseResoure($data);

        return response()->json(['data' => $data1], 201);
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
    public function update(ConsultNcdRiskScreeningBloodGlucoseRequest $request, $id)
    {
        $data = ConsultNcdRiskScreeningBloodGlucose::findorfail($id)->update($request->all());

        return ConsultNcdRiskScreeningBloodGlucoseResoure::collection($data);
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
