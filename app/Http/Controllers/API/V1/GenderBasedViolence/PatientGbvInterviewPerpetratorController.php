<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvInterviewPerpetratorRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewPerpetratorResource;
use App\Models\V1\GenderBasedViolence\PatientGbvInterviewPerpetrator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvInterviewPerpetratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvInterviewPerpetrator::query()->with(['patientGbv', 'facility'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvInterviewPerpetrator = QueryBuilder::for($query)
            ->defaultSort('-perpetrator_age')
            ->allowedSorts('perpetrator_age');

        return PatientGbvInterviewPerpetratorResource::collection($patientGbvInterviewPerpetrator->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvInterviewPerpetratorRequest $request)
    {
        $data = PatientGbvInterviewPerpetrator::create($request->validated());

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
    public function update(PatientGbvInterviewPerpetratorRequest $request, PatientGbvInterviewPerpetrator $patientGbvInterviewPerpetrator)
    {
        $patientGbvInterviewPerpetrator->update($request->validated());

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
