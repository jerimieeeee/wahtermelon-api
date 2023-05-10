<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvInterviewSummaryRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewSummaryResource;
use App\Models\V1\GenderBasedViolence\PatientGbvInterviewSummary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvInterviewSummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvInterviewSummary::query()
            ->with('patientGbv')
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvInterviewSummary = QueryBuilder::for($query);

        return PatientGbvInterviewSummaryResource::collection($patientGbvInterviewSummary->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvInterviewSummaryRequest $request)
    {
        $data = PatientGbvInterviewSummary::create($request->validated());

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
    public function update(PatientGbvInterviewSummaryRequest $request, PatientGbvInterviewSummary $patientGbvInterviewSummary)
    {
        $patientGbvInterviewSummary->update($request->safe()->only(['interview_datetime', 'interview_place', 'alleged_perpetrator', 'interview_notes']));

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
