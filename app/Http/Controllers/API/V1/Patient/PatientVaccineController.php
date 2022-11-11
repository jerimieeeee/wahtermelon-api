<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientVaccineRequest;
use App\Http\Requests\API\V1\Patient\PatientVaccineUpdateRequest;
use App\Http\Resources\API\V1\Patient\PatientVaccineResource;
use App\Models\V1\Patient\PatientVaccine;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


/**
 * @group Patient Vaccine Management
 *
 * APIs for managing Patient Vaccine information
 * @subgroup Patient Vaccine
 * @subgroupDescription Patient Vaccine management.
 */

class PatientVaccineController extends Controller
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
     * Store a newly created Patient Vaccine resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Patient\PatientVaccineResource
     * @apiResourceModel App\Models\V1\Patient\PatientVaccine
     * @param PatientVaccineRequest $request
     * @return JsonResponse
     */
    public function store(PatientVaccineRequest $request): JsonResponse
    {
            $vaccine = $request->input('vaccines');
            foreach($vaccine as $value){
                PatientVaccine::updateOrCreate(['patient_id' => $request->patient_id, 'vaccine_id' => $value['vaccine_id'], 'vaccine_date' => $value['vaccine_date']],
                ['patient_id' => $request->input('patient_id'),'user_id' => $request->input('user_id')] + $value);
            }

            $patientvaccines = PatientVaccine::where('patient_id', '=', $request->patient_id)->orderBy('vaccine_date', 'ASC')->get();

            return response()->json([
                'message' => 'Vaccine Successfully Saved',
                'data' => $patientvaccines
            ], 201);
    }

    /**
     * Show the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Patient\PatientVaccineResource
     * @apiResourceModel App\Models\V1\Patient\PatientVaccine
     * @param PatientVaccine $patientvaccine
     * @return PatientVaccineResource
     */
    public function show($id)
    {
        return PatientVaccine::where('patient_id', '=', $id)
        ->orderBy('vaccine_id', 'asc')
        ->orderBy('vaccine_date', 'asc')
        ->orderBy('status_id', 'asc')
        ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientVaccineUpdateRequest $request, $id): JsonResponse
    {
        PatientVaccine::findorfail($id)->update($request->all());
        return response()->json('Vaccine Successfully Updated');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        PatientVaccine::findorfail($id)->forceDelete($request->all());
        return response()->json('Vaccine Successfully Deleted');
    }
}
