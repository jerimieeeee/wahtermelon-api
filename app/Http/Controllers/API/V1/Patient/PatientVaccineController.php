<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientVaccineRequest;
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
        try{
            $vaccine = $request->input('vaccine_id');
            $vaccine_array = [];
            foreach($vaccine as $key => $value){
                $data = PatientVaccine::firstOrNew(['patient_id' => $request->input('patient_id') , 'vaccine_id' => $value]);
                $data->user_id = $request->input('user_id');
                $data->status_id = $request->input('status_id')[$key] == null ? null : ($request->input('status_id')[$key]);
                $data->vaccine_id = $value;
                $data->vaccine_date = $request->input('vaccine_date')[$key] == null ? null : Carbon::parse($request->input('vaccine_date')[$key])->format('Y-m-d');
            $data->save();
            array_push($vaccine_array, $value);
            }
            // PatientVaccine::whereNotIn('vaccine_id', $vaccine_array)
            // ->where('patient_id', '=', $data->patient_id )
            // ->forceDelete();

            return response()->json([
                'message' => 'Vaccine Successfully Saved',
            ], 201);

            }catch(Exception $error) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Vaccine Saving Error',
                    'error' => $error,
                ]);
            }
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
    public function update(Request $request, $id)
    {
        PatientVaccine::findorfail($id)->update($request->all());
        return response()->json('Vaccine Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
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
