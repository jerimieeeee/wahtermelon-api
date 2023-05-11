<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConferenceRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConferenceResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConference;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvConference::query()
            ->with('patientGbv')
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConference = QueryBuilder::for($query);

        return PatientGbvConferenceResource::collection($patientGbvConference->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvConferenceRequest $request)
    {
        $data = PatientGbvConference::create($request->validated());

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
    public function update(PatientGbvConferenceRequest $request, PatientGbvConference $patientGbvConference)
    {
        $patientGbvConference->update($request->safe()->only(['conference_date', 'notes']));

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
