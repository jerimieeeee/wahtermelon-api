<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\PatientMcPostRegistrationRequest;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Services\MaternalCare\MaternalCareRecordService;
use Illuminate\Http\Request;

/**
 * @group Maternal Care Management
 *
 * APIs for managing maternal care information
 * @subgroup Post Registration
 * @subgroupDescription Post Registration management.
 */
class PatientMcPostRegistrationController extends Controller
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
    public function store(PatientMcPostRegistrationRequest $request, MaternalCareRecordService $maternalCareRecordService)
    {
        //return $data = PatientMcPostRegistration::create($request->all());
        $mc = $maternalCareRecordService->getLatestMcRecord($request->all());
        if(!$mc){
            $mc = PatientMc::create($request-> validatedWithCasts());
            return $mc->postRegister()->create($request->validated());
        }
        return PatientMc::find($mc->id)->postRegister()->updateOrCreate(['patient_mc_id' => $mc->id],$request->validated());
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
