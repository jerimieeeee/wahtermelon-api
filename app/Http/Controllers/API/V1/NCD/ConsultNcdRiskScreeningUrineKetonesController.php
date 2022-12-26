<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\ConsultNcdRiskScreeningUrineKetonesRequest;
use App\Http\Resources\API\V1\NCD\ConsultNcdRiskScreeningUrineKetonesResource;
use App\Models\V1\NCD\ConsultNcdRiskScreeningUrineKetones;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Non-Communicable Disease Management
 *
 * APIs for managing Non-Communicable Disease information
 * @subgroup Risk Screening Urine Ketones
 * @subgroupDescription Risk Screening Urine Ketones management.
 */
class ConsultNcdRiskScreeningUrineKetonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam consult_ncd_risk_id string Patient record to view.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ConsultNcdRiskScreeningUrineKetones::query();
        $consultNcdRiskUrineKetones = QueryBuilder::for($query)
            ->when(isset($request->consult_ncd_risk_id), function ($q) use($request){
                $q->whereConsultNcdRiskId($request->consult_ncd_risk_id);
            })
            ->get();
        return ConsultNcdRiskScreeningUrineKetonesResource::collection($consultNcdRiskUrineKetones);
    }

    /**
     * Store a newly created Consult Risk Screening Urine Ketons resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\NCD\ConsultNcdRiskScreeningUrineKetonesResource
     * @apiResourceModel App\Models\V1\NCD\ConsultNcdRiskScreeningUrineKetones
     * @param ConsultNcdRiskScreeningUrineKetonesRequest $request
     * @return JsonResponse
     */
    public function store(ConsultNcdRiskScreeningUrineKetonesRequest $request)
    {
        $data = ConsultNcdRiskScreeningUrineKetones::updateOrCreate(['consult_ncd_risk_id' => $request['consult_ncd_risk_id']],$request->validated());
        $data1 = new ConsultNcdRiskScreeningUrineKetonesResource($data);
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
    public function update(ConsultNcdRiskScreeningUrineKetonesRequest $request, $id)
    {
        $data = ConsultNcdRiskScreeningUrineKetones::findorfail($id)->update($request->all());

        return ConsultNcdRiskScreeningUrineKetonesResource::collection($data);
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
