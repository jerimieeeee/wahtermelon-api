<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\PatientNcdRequest;
use App\Http\Resources\API\V1\NCD\PatientNcdResource;
use App\Models\V1\NCD\PatientNcd;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @authenticated
 * @group Non-Communicable Disease Management
 *
 * APIs for managing Non-Communicable Disease information
 * @subgroup Non-Communicable Disease Record
 * @subgroupDescription Non-Communicable Disease management.
 */
class PatientNcdController extends Controller
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
     * Store a newly created Patient/Ncd Risk Assessment resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\NCD\PatientNcdResource
     * @apiResourceModel App\Models\V1\NCD\PatientNcd
     * @param PatientNcdRequest $request
     * @return JsonResponse
     */
    public function store(PatientNcdRequest $request)
    {
        DB::transaction(function () use($request) {

            $data = PatientNcd::create($request->all());

            $data->riskAssessment()->create($request->all() + ['patient_ncd_id' => $request->id] + ['assessment_date' => $request->date_enrolled]);

        });

        $patientNcdRiskAssessment = PatientNcd::where('patient_id', '=', $request->patient_id)->with('riskAssessment')->get();
        $patientNcdRiskAssessment1 = PatientNcdResource::collection($patientNcdRiskAssessment);

        return response()->json(['data' => $patientNcdRiskAssessment1], 201);
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
    public function update(PatientNcdRequest $request, PatientNcd $patientNcd)
    {
        DB::transaction(function () use($patientNcd, $request) {

            $patientNcd->update($request->all());

            $patientNcd->riskAssessment()->update($request->except('date_enrolled') + ['patient_ncd_id' => $patientNcd->id] + ['assessment_date' => $request->date_enrolled]);

        });

        $patientNcdRiskAssessment = PatientNcd::where('patient_id', '=', $request->patient_id)->with('riskAssessment')->get();
        return PatientNcdResource::collection($patientNcdRiskAssessment);
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
