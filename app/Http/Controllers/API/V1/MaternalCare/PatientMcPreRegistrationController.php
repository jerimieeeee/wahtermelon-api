<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use Illuminate\Http\Request;

class PatientMcPreRegistrationController extends Controller
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
        /*//return Patient::with('patientMc')->get();
        return $a = PatientMcPostRegistration::with(['patientMc'])->first();
        //return $a->patientMcPostRegistration;
        return $mc = PatientMc::with('patientMcPostRegistration')->first();*/
        /*return $mc = PatientMc::withWhereHas('postRegister', function($query) {
            $query->where('end_pregnancy', false);
        })->get();*/
        return $mc = PatientMc::addSelect([
                'post_registration' => PatientMcPostRegistration::select('post_registration_date')
                ->whereColumn('patient_mc_id', 'patient_mc.id')
                ->where('end_pregnancy', false),
                'pre_registration' => PatientMcPreRegistration::select('pre_registration_date')
                ->whereColumn('patient_mc_id', 'patient_mc.id')
        ])
        ->havingRaw('(pre_registration IS NULL AND post_registration IS NOT NULL) OR (pre_registration IS NOT NULL AND post_registration IS NULL) OR (pre_registration IS NOT NULL AND post_registration IS NOT NULL) OR (pre_registration IS NULL AND post_registration IS NULL)')
            ->latest('post_registration', 'pre_registration')
            ->first();
        /*if(!$mc){
            return $mc = PatientMc::create($request->all());
        }*/

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
