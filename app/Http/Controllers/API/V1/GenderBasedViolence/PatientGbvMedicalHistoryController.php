<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvMedicalHistoryRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvMedicalHistoryResource;
use App\Models\V1\GenderBasedViolence\PatientGbvMedicalHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient GBV Management
 *
 * APIs for managing Patient GBV information
 *
 * @subgroup Patient GBV Medical History
 *
 * @subgroupDescription Patient GBV Medical History Management.
 */
class PatientGbvMedicalHistoryController extends Controller
{
    /**
     * Display a listing of the Patient GBV Medical History resource.
     *
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvMedicalHistoryResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvMedicalHistory
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvMedicalHistory::query()
            ->with(['patientGbvIntake', 'gbvGeneralSurvey'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvMedicalHistory = QueryBuilder::for($query);

        return PatientGbvMedicalHistoryResource::collection($patientGbvMedicalHistory->get());
    }

    /**
     * Store a newly created Patient GBV Medical History resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvMedicalHistoryResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvMedicalHistory
     */
    public function store(PatientGbvMedicalHistoryRequest $request)
    {
        $data = PatientGbvMedicalHistory::updateOrCreate(
            [
                'patient_id' => $request->patient_id,
                'patient_gbv_intake_id' => $request->patient_gbv_intake_id,
            ],
            $request->validated()
        );

        return response()->json(['data' => new PatientGbvMedicalHistoryResource($data), 'status' => 'Successfully saved'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientGbvMedicalHistoryRequest $request, PatientGbvMedicalHistory $patientGbvMedicalHistory)
    {
        $patientGbvMedicalHistory->update($request->safe()->except('patient_gbv_intake_id', 'patient_id'));

        return response()->json(['status' => 'Update successful!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
