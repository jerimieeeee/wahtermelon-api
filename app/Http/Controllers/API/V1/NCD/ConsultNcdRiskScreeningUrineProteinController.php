<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\ConsultNcdRiskScreeningUrineProteinRequest;
use App\Http\Resources\API\V1\NCD\ConsultNcdRiskScreeningUrineProteinResource;
use App\Models\V1\NCD\ConsultNcdRiskScreeningUrineProtein;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Non-Communicable Disease Management
 *
 * APIs for managing Non-Communicable Disease information
 *
 * @subgroup Risk Screening Urine Protein
 *
 * @subgroupDescription Risk Screening Urine Protein management.
 */
class ConsultNcdRiskScreeningUrineProteinController extends Controller
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
        $query = ConsultNcdRiskScreeningUrineProtein::query();
        $consultNcdRiskUrineProtein = QueryBuilder::for($query)
            ->when(isset($request->consult_ncd_risk_id), function ($q) use ($request) {
                $q->whereConsultNcdRiskId($request->consult_ncd_risk_id);
            })
            ->get();

        return ConsultNcdRiskScreeningUrineProteinResource::collection($consultNcdRiskUrineProtein);
    }

    /**
     * Store a newly created Consult Risk Questionnaire resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\NCD\ConsultNcdRiskScreeningUrineProteinResource
     *
     * @apiResourceModel App\Models\V1\NCD\ConsultNcdRiskScreeningUrineProtein
     *
     * @return JsonResponse
     */
    public function store(ConsultNcdRiskScreeningUrineProteinRequest $request)
    {
        $data = ConsultNcdRiskScreeningUrineProtein::updateOrCreate(['consult_ncd_risk_id' => $request['consult_ncd_risk_id']], $request->validated());
        $data1 = new ConsultNcdRiskScreeningUrineProteinResource($data);

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
    public function update(ConsultNcdRiskScreeningUrineProteinRequest $request, $id)
    {
        $data = ConsultNcdRiskScreeningUrineProtein::findorfail($id)->update($request->all());

        return ConsultNcdRiskScreeningUrineProteinResource::collection($data);
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
