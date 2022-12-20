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
     * @queryParam patient_ncd_id Identification code of the patient ncd.
     * @queryParam sort string Sort assessment_date. Add hyphen (-) to descend the list: e.g. assessment_date. Example: assessment_date
     * @queryParam client_type Consultation Status. Example: Walk-in
     * @queryParam location Consultation Status. Example: Health Facility
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\NCD\ConsultNcdRiskAssessmentResource
     * @apiResourceModel App\Models\V1\NCD\ConsultNcdRiskAssessment paginate=15
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): ResourceCollection
    {
        // $query = ConsultNcdRiskAssessment::query();
        // $consultNcdRisk = QueryBuilder::for($query)
        //     ->when(isset($request->patient_ncd_id), function ($q) use($request){
        //         $q->wherePatientNcdId($request->patient_ncd_id);
        //     })
        //     ->get();
        // return ConsultNcdRiskAssessmentResource::collection($consultNcdRisk);

        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $consultNcdRiskAssessment = QueryBuilder::for(ConsultNcdRiskAssessment::class)
        ->when(isset($request->patient_id), function($q) use($request){
            $q->where('patient_id', $request->patient_id);
        })
        // ->when(isset($request->patient_ncd_id), function($q) use($request){
        //     $q->where('patient_ncd_id', '=', $request->patient_ncd_id);
        // })
        // ->when(isset($request->assessment_date), function($q) use($request){
        //     $q->where('assessment_date', '=', $request->assessment_date);
        // })
        ->when(isset($request->consult_id), function($q) use($request){
            $q->where('consult_id', '=', $request->consult_id);
        })
        // ->when(isset($request->client_type), function($q) use($request){
        //     $q->where('client_type', '=', $request->client_type);
        // })
        // ->when(isset($request->location), function($q) use($request){
        //     $q->where('location', '=', $request->location);
        // })
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
     * Store a newly created resource in storage.
     *
     * @param ConsultNcdRiskAssessmentRequest $request
     * @return Response
     */
    public function store(ConsultNcdRiskAssessmentRequest $request)
    {

            $data = ConsultNcdRiskScreeningBloodGlucose::create($request->all());

            $data = ConsultNcdRiskAssessment::create($request->all());

            return new ConsultNcdRiskAssessmentResource($data);

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
        $ncdRisk->update($request->validated());
        return ConsultNcdRiskAssessmentResource::collection(ConsultNcdRiskAssessment::where('patient_ncd_id', $request->patient_ncd_id)->get());
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
