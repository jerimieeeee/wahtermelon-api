<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
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
    public function store(Request $request, MaternalCareRecordService $maternalCareRecordService)
    {
        $mc = $maternalCareRecordService->getLatestMcRecord($request->all());
        if($mc) {
            return PatientMc::find($mc->id)->prenatal()->updateOrCreate(['patient_mc_id' => $mc->id],$request->all());
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
