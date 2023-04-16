<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\PatientMcPreRegistrationRequest;
use App\Http\Resources\API\V1\MaternalCare\PatientMcPreRegistrationResource;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPreRegistration;
use App\Services\MaternalCare\MaternalCareRecordService;
use Illuminate\Http\Response;

/**
 * @authenticated
 *
 * @group Maternal Care Management
 *
 * APIs for managing maternal care information
 *
 * @subgroup Pre Registration
 *
 * @subgroupDescription Pre Registration management.
 */
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
        if (! $mc) {
            $mc = PatientMc::create($request->validatedWithCasts());

            return $mc->preRegister()->create($request->validatedWithCasts());
        }

        return PatientMc::find($mc->id)->preRegister()->updateOrCreate(['patient_mc_id' => $mc->id], $request->validatedWithCasts());
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientMcPreRegistration $preRegistration): PatientMcPreRegistrationResource
    {
        return new PatientMcPreRegistrationResource($preRegistration);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(PatientMcPreRegistrationRequest $request, PatientMcPreRegistration $preRegistration)
    {
        $preRegistration->update($request->validatedWithCasts());

        return $preRegistration;
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
