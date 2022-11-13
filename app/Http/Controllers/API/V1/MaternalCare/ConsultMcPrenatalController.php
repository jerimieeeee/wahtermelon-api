<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\ConsultMcPrenatalRequest;
use App\Models\V1\MaternalCare\ConsultMcPrenatal;
use App\Models\V1\MaternalCare\PatientMc;
use App\Services\MaternalCare\MaternalCareRecordService;
use Illuminate\Http\Request;

class ConsultMcPrenatalController extends Controller
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
    public function store(ConsultMcPrenatalRequest $request)
    {
        /*$mc = $maternalCareRecordService->getLatestMcRecord($request->validated());
        if($mc) {
            return PatientMc::find($mc->id)->prenatal()->updateOrCreate(['patient_mc_id' => $mc->id],$request->validated());
        }*/
        //return $request->validatedWithCasts();
        ConsultMcPrenatal::updateOrCreate(['patient_mc_id' => $request->patient_mc_id, 'prenatal_date' => $request->prenatal_date], $request->validatedWithCasts());
        $mc = new MaternalCareRecordService();
        return $mc->updateVisitSequence($request->patient_mc_id, 'ConsultMcPrenatal', 'prenatal_date');
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
