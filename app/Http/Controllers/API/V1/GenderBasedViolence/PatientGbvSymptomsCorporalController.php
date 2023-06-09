<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvSymptomsAnogenitalRequest;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvSymptomsCorporalRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvSymptomsAnogenitalResource;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvSymptomsCorporalResource;
use App\Models\V1\GenderBasedViolence\PatientGbvSymptomsAnogenital;
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
            ->with(['patientGbvIntake', 'symptomsCorporal', 'infoSource'])
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
            ->Forcedelete();

        $symptoms_corporal = $request->safe()->corporal_array;

        foreach ($symptoms_corporal as $value) {
            PatientGbvSymptomsCorporal::updateOrCreate([
                'patient_id' => $request->patient_id,
                'patient_gbv_intake_id' => $request->patient_gbv_intake_id,
                'info_source_id' => $request->info_source_id,
                'corporal_symptoms_id' => $value['corporal_symptoms_id'],
                'remarks' => $request->remarks,
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
    public function update(PatientGbvSymptomsCorporalRequest $request, PatientGbvSymptomsCorporal $patientGbvSymptomsCorporal)
    {
        $patientGbvSymptomsCorporal->update($request->safe()->only(['corporal_symptoms_id', 'info_source_id', 'remarks']));

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
