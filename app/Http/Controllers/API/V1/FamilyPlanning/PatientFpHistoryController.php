<?php

namespace App\Http\Controllers\API\V1\FamilyPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpHistoryRequest;
use App\Models\V1\FamilyPlanning\PatientFpHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientFpHistoryController extends Controller
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
    public function store(PatientFpHistoryRequest $request): JsonResponse
    {
        $history = $request->input('history');

        PatientFpHistory::query()
            ->where('patient_id', $request->safe()->patient_id)->forceDelete();

        foreach ($history as $value) {
            PatientFpHistory::updateOrCreate(['patient_fp_id' => $request->patient_fp_id, 'patient_id' => $request->patient_id, 'history_code' => $value['history_code']],
                $value);
        }

        return response()->json([
            'message' => 'History Successfully Saved',
        ], 201);
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
