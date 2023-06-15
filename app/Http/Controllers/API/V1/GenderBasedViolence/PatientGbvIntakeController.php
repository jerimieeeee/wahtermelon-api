<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvIntakeRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvIntakeResource;
use App\Models\V1\GenderBasedViolence\PatientGbvIntake;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvIntakeController extends Controller
{
    /**
     * Display a listing of the Patient GBV resource.
     *
     * @queryParam sort string Sort case_date, of the patient gbv. Example: -case_date
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvIntakeResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvIntake
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvIntake::query()
            ->with(['interview',
                'interviewPerpetrator', 'interviewSexualAbuses', 'interviewPhysicalAbuses',
                'interviewNeglectAbuses', 'interviewEmotionalAbuses',
                'interviewSummaries', 'interviewDevScreening', 'relation', 'medicalHistory'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvIntake = QueryBuilder::for($query)
            ->defaultSort('-case_date')
            ->allowedSorts('case_date');

        return PatientGbvIntakeResource::collection($patientGbvIntake->get());
    }

    /**
     * Store a newly created Patient GBV resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvIntakeResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvIntake
     */
    public function store(PatientGbvIntakeRequest $request): JsonResponse
    {
        $data = PatientGbvIntake::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Successfully saved'], 201);
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
    public function update(PatientGbvIntakeRequest $request, PatientGbvIntake $patientGbvIntake)
    {
        $patientGbvIntake->update($request->validated());

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
