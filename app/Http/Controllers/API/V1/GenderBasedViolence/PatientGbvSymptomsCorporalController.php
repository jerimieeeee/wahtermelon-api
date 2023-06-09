<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvSymptomsCorporalRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvSymptomsCorporalResource;
use App\Models\V1\GenderBasedViolence\PatientGbvSymptomsCorporal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvSymptomsCorporalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvSymptomsCorporal::query()
                ->with(['patientGbvIntake', 'symptomsAnogenital'])
                ->when(isset($request->patient_id), function ($query) use ($request) {
                    return $query->wherePatientId($request->patient_id);
                });
        $patientGbvSymptomsCorporal = QueryBuilder::for($query);

        return PatientGbvSymptomsCorporalResource::collection($patientGbvSymptomsCorporal->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvSymptomsCorporalRequest $request)
    {
        PatientGbvSymptomsCorporal::query()
            ->where('patient_id', $request->safe()->patient_id)
            ->where('patient_gbv_intake_id', $request->safe()->patient_gbv_intake_id)
            ->delete();

        $corporal_arr = $request->safe()->corporal_array;

        foreach ($corporal_arr as $value) {
            PatientGbvSymptomsCorporal::updateOrCreate([
                'patient_id' => $request->patient_id,
                'patient_gbv_intake_id' => $request->patient_gbv_intake_id,
                'info_source_id' => $value['info_source_id'],
                'corporal_symptoms_id' => $value['corporal_symptoms_id'],
            ], $value);
        }

        return response()->json(['message' => 'Successfully Saved!'], 201);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
