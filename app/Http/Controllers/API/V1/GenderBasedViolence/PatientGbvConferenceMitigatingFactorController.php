<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConferenceMitigatingFactorRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConferenceMitigatingFactorResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConferenceMitigatingFactor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvConferenceMitigatingFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvConferenceMitigatingFactor::query()
            ->with(['patientGbvConference', 'mitigatingFactor'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConferenceMitigatingFactor = QueryBuilder::for($query);

        return PatientGbvConferenceMitigatingFactorResource::collection($patientGbvConferenceMitigatingFactor->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvConferenceMitigatingFactorRequest $request)
    {
        $data = PatientGbvConferenceMitigatingFactor::create($request->validated());

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
    public function update(PatientGbvConferenceMitigatingFactorRequest $request, PatientGbvConferenceMitigatingFactor $patientGbvConferenceMitigatingFactor)
    {
        $patientGbvConferenceMitigatingFactor->update($request->safe()->only(['factor_code', 'mitigating_factor_remarks']));

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
