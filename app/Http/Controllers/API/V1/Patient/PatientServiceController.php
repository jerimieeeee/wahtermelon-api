<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientServiceRequest;
use App\Http\Resources\API\V1\Patient\PatientServiceResource;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PatientServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = QueryBuilder::for(PatientService::class)
            ->when($request->filled('patient_id'), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with(['patient', 'facility', 'user', 'libService'])
            ->defaultSort('service_date')
            ->allowedSorts('service_date');
        return PatientServiceResource::collection($data->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientServiceRequest $request)
    {
        $validatedData = $request->validated();
        $patientService = PatientService::updateOrCreate(
            [
                'patient_id' => $validatedData['patient_id'],
                'service_date' => $validatedData['service_date'],
                'lib_service_id' => $validatedData['lib_service_id']
            ], $validatedData
        );

        return response()->json([
            'message' => 'Patient service created successfully',
            'data' => $patientService
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientService $patientService)
    {
        $data = QueryBuilder::for(PatientService::class)
                ->with(['patient', 'facility', 'user', 'libService'])
                ->where('id', $patientService->id)
                ->first();
        return new PatientServiceResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientServiceRequest $request, PatientService $patientService)
    {
        $validatedData = $request->validated();
        $patientService->update($validatedData);

        return response()->json([
            'message' => 'Patient service updated successfully',
            'data' => $patientService
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
