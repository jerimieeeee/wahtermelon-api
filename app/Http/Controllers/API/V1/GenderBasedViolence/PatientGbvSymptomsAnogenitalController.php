<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvSymptomsAnogenitalRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvSymptomsAnogenitalResource;
use App\Models\V1\GenderBasedViolence\PatientGbvSymptomsAnogenital;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvSymptomsAnogenitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvSymptomsAnogenital::query()
            ->with(['patientGbvIntake', 'symptomsAnogenital'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvSymptomsAnogenital = QueryBuilder::for($query);

        return PatientGbvSymptomsAnogenitalResource::collection($patientGbvSymptomsAnogenital->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvSymptomsAnogenitalRequest $request)
    {
        PatientGbvSymptomsAnogenital::query()
            ->where('patient_id', $request->safe()->patient_id)
            ->where('patient_gbv_intake_id', $request->safe()->patient_gbv_intake_id)
            ->Forcedelete();

        $symptoms_anogenital = $request->safe()->anogenital_array;

        foreach ($symptoms_anogenital as $value) {
            PatientGbvSymptomsAnogenital::updateOrCreate([
                'patient_id' => $request->patient_id,
                'patient_gbv_intake_id' => $request->patient_gbv_intake_id,
                'info_source_id' => $value['info_source_id'],
                'anogenital_symptoms_id' => $value['anogenital_symptoms_id'],
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
    public function update(PatientGbvSymptomsAnogenitalRequest $request, PatientGbvSymptomsAnogenital $patientGbvSymptomsAnogenital)
    {
        $patientGbvSymptomsAnogenital->update($request->safe()->only(['anogenital_symptoms_id', 'remarks']));

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
