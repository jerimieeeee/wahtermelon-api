<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvLegalCaseRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvLegalCaseResource;
use App\Models\V1\GenderBasedViolence\PatientGbvLegalCase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvLegalCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvLegalCase::query()
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });

        $patientGbvLegalCase = QueryBuilder::for($query);

        return PatientGbvLegalCaseResource::collection($patientGbvLegalCase->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvLegalCaseRequest $request)
    {
        $data = PatientGbvLegalCase::create($request->validated());

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
    public function update(PatientGbvLegalCaseRequest $request, PatientGbvLegalCase $patientGbvLegalCase)
    {
        $patientGbvLegalCase->update($request->validated());

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
