<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\ConsultNcdRiskAssessmentRequest;
use App\Http\Resources\API\V1\NCD\ConsultNcdRiskAssessmentResource;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\NCD\ConsultNcdRiskScreeningBloodGlucose;
use App\Models\V1\NCD\PatientNcd;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

/**
 * @authenticated
 * @group Non-Communicable Disease Management
 *
 * APIs for managing Non-Communicable Disease information
 * @subgroup Risk Assessment
 * @subgroupDescription Risk Assessment management.
 */
class ConsultNcdRiskAssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id Identification code of the patient.
     * @queryParam consult_id Identification code of the consult.
     * @queryParam id Identification code of the consult ncd risk assessment.
     * @queryParam sort string Sort assessment_date. Add hyphen (-) to descend the list: e.g. assessment_date. Example: assessment_date
     * @queryParam consult_id Consultation ID. Example: 1
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\NCD\ConsultNcdRiskAssessmentResource
     * @apiResourceModel App\Models\V1\NCD\ConsultNcdRiskAssessment paginate=15
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $consultNcdRiskAssessment = QueryBuilder::for(ConsultNcdRiskAssessment::class)
        ->when(isset($request->patient_id), function($q) use($request){
            $q->where('patient_id', $request->patient_id);
        })
        ->when(isset($request->consult_id), function($q) use($request){
            $q->where('consult_id', '=', $request->consult_id);
        })
        ->when(isset($request->id), function($q) use($request){
            $q->where('id', '=', $request->id);
        })
        ->with('riskScreeningGlucose', 'riskScreeningLipid', 'riskScreeningKetones', 'riskScreeningProtein', 'riskQuestionnaire', 'patientNcdRecord', 'ncdRecordDiagnosis', 'ncdRecordTargetOrgan', 'ncdRecordCounselling')

        ->defaultSort('assessment_date')
        ->allowedSorts('assessment_date');

        if ($perPage === 'all') {
            return ConsultNcdRiskAssessmentResource::collection($consultNcdRiskAssessment->get());
        }

        return ConsultNcdRiskAssessmentResource::collection($consultNcdRiskAssessment->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created Consult NCD Risk Assessment resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\NCD\ConsultNcdRiskAssessmentResource
     * @apiResourceModel App\Models\V1\NCD\ConsultNcdRiskAssessment
     * @param ConsultNcdRiskAssessmentRequest $request
     * @return JsonResponse
     */
    public function store(ConsultNcdRiskAssessmentRequest $request)
    {
        $data = DB::transaction(function () use($request) {
            $data = PatientNcd::create(['date_enrolled' => $request->assessment_date, 'patient_id' => $request->patient_id]);
            return $data->riskAssessment()->create($request->validatedWithCasts());
        });

        return response()->json(['data' => $data], 201);
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
     * @param ConsultNcdRiskAssessmentRequest $request
     * @param ConsultNcdRiskAssessment $ncdRisk
     * @return Response
     */
    public function update(ConsultNcdRiskAssessmentRequest $request, ConsultNcdRiskAssessment $ncdRisk)
    {
        $data = DB::transaction(function () use($request, $ncdRisk) {

            $ncdRisk->update($request->validatedWithCasts());

            $ncdRisk->patientNcd()->update($request->validatedWithCasts('date_enrolled', 'patient_id') + ['patient_id' => $request->patient_id, 'date_enrolled' =>$request->assessment_date]);
        });

        return response()->json(['data' => $data], 201);
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
