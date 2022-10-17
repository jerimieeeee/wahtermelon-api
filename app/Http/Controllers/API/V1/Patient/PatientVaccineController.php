<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Models\V1\Patient\PatientVaccine;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $vaccine = $request->input('vaccines');
            $vaccine_array = [];
            foreach($vaccine as $key => $value){
                $data = PatientVaccine::firstOrNew(['patient_id' => $request->input('patient_id'), 'vaccine_id' => $value]);
                // $data->patient_id = $request->input('patient_id');
                // $data->patient_ccdev_id = $request->input('patient_ccdev_id');
                $data->user_id = $request->input('user_id');
                $data->vaccine_id = $value;
                $data->vaccine_date = $request->input('vaccine_date')[$key] == null ? null : Carbon::parse($request->input('vaccine_date')[$key])->format('Y/m/d');
            $data->save();
            array_push($vaccine_array, $value);

            }
            PatientVaccine::whereNotIn('vaccine_id', $vaccine_array)
            ->where('patient_id', '=', $data->patient_id )
            ->delete();

            return response()->json([
                // 'status_code' => 200,
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
        //
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
