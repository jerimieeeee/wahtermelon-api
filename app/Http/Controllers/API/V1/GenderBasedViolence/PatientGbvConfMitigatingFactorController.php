<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConfMitigatingFactorRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConfMitigatingFactorResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConfMitigatingFactor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvConfMitigatingFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvConfMitigatingFactor::query()
            ->with(['patientGbvConf', 'mitigatingFactor'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConfMitigatingFactor = QueryBuilder::for($query);

        return PatientGbvConfMitigatingFactorResource::collection($patientGbvConfMitigatingFactor->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvConfMitigatingFactorRequest $request)
    {
        $data = PatientGbvConfMitigatingFactor::create($request->validated());

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
    public function update(PatientGbvConfMitigatingFactorRequest $request, PatientGbvConfMitigatingFactor $patientGbvConfMitigatingFactor)
    {
        $patientGbvConfMitigatingFactor->update($request->safe()->only(['factor_code', 'mitigating_factor_remarks']));

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
