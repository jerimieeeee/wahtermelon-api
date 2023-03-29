<?php

namespace App\Http\Controllers\API\V1\MaternalCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\MaternalCare\PatientMcPostRegistrationRequest;
use App\Http\Resources\API\V1\MaternalCare\PatientMcPostRegistrationResource;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Services\MaternalCare\MaternalCareRecordService;
use Illuminate\Http\Response;

/**
 * @authenticated
 *
 * @group Maternal Care Management
 *
 * APIs for managing maternal care information
 *
 * @subgroup Post Registration
 *
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
        if (! $mc) {
            $mc = PatientMc::create($request->validatedWithCasts());

            return $mc->postRegister()->create($request->validated());
        }

        return PatientMc::find($mc->id)->postRegister()->updateOrCreate(['patient_mc_id' => $mc->id], $request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientMcPostRegistration $postRegistration): PatientMcPostRegistrationResource
    {
        return new PatientMcPostRegistrationResource($postRegistration);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(PatientMcPostRegistrationRequest $request, PatientMcPostRegistration $postRegistration)
    {
        $postRegistration->update($request->validatedWithCasts());

        return $postRegistration;
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
