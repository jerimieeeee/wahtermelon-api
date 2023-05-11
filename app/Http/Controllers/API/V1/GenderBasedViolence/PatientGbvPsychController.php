<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvPsychRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvPsychResource;
use App\Models\V1\GenderBasedViolence\PatientGbvPsych;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvPsychController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvPsych::query()
            ->with(['patientGbv', 'participant'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvPsych = QueryBuilder::for($query);

        return PatientGbvPsychResource::collection($patientGbvPsych->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvPsychRequest $request)
    {
        $data = PatientGbvPsych::create($request->validated());

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
    public function update(PatientGbvPsychRequest $request, PatientGbvPsych $patientGbvPsych)
    {
        $patientGbvPsych->update($request->safe()->only(['scheduled_date', 'participant_id', 'actual_date', 'md_name']));

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
