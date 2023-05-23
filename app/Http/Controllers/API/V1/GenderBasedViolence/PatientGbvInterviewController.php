<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvInterviewRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewResource;
use App\Models\V1\GenderBasedViolence\PatientGbvInterview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvInterviewController extends Controller
{
    /**
     * Display a listing of the Patient GBV Interview resource.
     *
     * @queryParam sort string Sort age of the patient. Example: -age
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvInterview
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvInterview::query()->with(['patientGbv', 'disclosed', 'abusedEpisode', 'abusedSite', 'behavior'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvInterview = QueryBuilder::for($query)
            ->defaultSort('-incident_first_datetime')
            ->allowedSorts('incident_first_datetime');

        return PatientGbvInterviewResource::collection($patientGbvInterview->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvInterviewRequest $request)
    {
        $data = PatientGbvInterview::create($request->validated());

        return response()->json(['data' => $data], 201);
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
    public function update(PatientGbvInterviewRequest $request, PatientGbvInterview $patientGbvInterview)
    {
        $patientGbvInterview->update($request->validated());

        return response()->json(['data' => $patientGbvInterview, 'status' => 'Successfully saved'], 201);
        // return response()->json(['status' => 'Update successful!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
