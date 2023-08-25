<?php

namespace App\Http\Controllers\API\V1\FamilyPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpChartRequest;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpChartUpdateRequest;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpMethodRequest;
use App\Http\Resources\API\V1\FamilyPlanning\PatientFpChartResource;
use App\Http\Resources\API\V1\FamilyPlanning\PatientFpMethodResource;
use App\Models\V1\FamilyPlanning\PatientFpChart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientFpChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientFpChartRequest $request): JsonResponse
    {
        $data = PatientFpChart::create($request->validated());

        return response()->json(['data' => new PatientFpChartResource($data), 'status' => 'Success'], 201);
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
    public function update(PatientFpChartUpdateRequest $request, PatientFpChart $patientFpChart)
    {
        $patientFpChart->update($request->only(['service_date', 'source_supply_code', 'next_service_date', 'quantity', 'remarks']));

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientFpChart $patientFpChart)
    {
        $patientFpChart->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
