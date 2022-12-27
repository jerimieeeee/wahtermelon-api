<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\ConsultNcdRiskQuestionnaireRequest;
use App\Http\Resources\API\V1\NCD\ConsultNcdRiskQuestionnaireResource;
use App\Models\V1\NCD\ConsultNcdRiskQuestionnaire;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Non-Communicable Disease Management
 *
 * APIs for managing Non-Communicable Disease information
 * @subgroup Risk Questionnaire
 * @subgroupDescription Risk Questionnaire.
 */
class ConsultNcdRiskQuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam consult_ncd_risk_id string Patient record to view.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ConsultNcdRiskQuestionnaire::query();
        $consultNcdRiskQuestionnaire = QueryBuilder::for($query)
            ->when(isset($request->consult_ncd_risk_id), function ($q) use($request){
                $q->whereConsultNcdRiskId($request->consult_ncd_risk_id);
            })
            ->get();
        return ConsultNcdRiskQuestionnaireResource::collection($consultNcdRiskQuestionnaire);
    }

    /**
     * Store a newly created Consult Risk Questionnaire resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\NCD\ConsultNcdRiskQuestionnaireResource
     * @apiResourceModel App\Models\V1\NCD\ConsultNcdRiskQuestionnaire
     * @param ConsultNcdRiskQuestionnaireRequest $request
     * @return JsonResponse
     */
    public function store(ConsultNcdRiskQuestionnaireRequest $request)
    {
        $data = ConsultNcdRiskQuestionnaire::updateOrCreate(['consult_ncd_risk_id' => $request['consult_ncd_risk_id']],$request->validated());
        $data1 = new ConsultNcdRiskQuestionnaireResource($data);
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
    public function update(ConsultNcdRiskQuestionnaireRequest $request, $id)
    {
        $data = ConsultNcdRiskQuestionnaire::findorfail($id)->update($request->all());

        return ConsultNcdRiskQuestionnaireResource::collection($data);
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
