<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\PatientMcPreRegistrationRequest;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Models\V1\Patient\Patient;
use App\Services\MaternalCare\MaternalCareRecordService;
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
    public function store(PatientMcPreRegistrationRequest $request, MaternalCareRecordService $maternalCareRecordService)
    {
        $mc = $maternalCareRecordService->getLatestMcRecord($request->validated());
        if(!$mc){
            $mc = PatientMc::create($request->validatedWithCasts());
            return $mc->preRegister()->create($request->validatedWithCasts());
        }
        return PatientMc::find($mc->id)->preRegister()->updateOrCreate(['patient_mc_id' => $mc->id],$request->validatedWithCasts());
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
