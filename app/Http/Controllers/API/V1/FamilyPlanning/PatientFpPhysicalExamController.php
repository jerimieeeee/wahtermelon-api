<?php

namespace App\Http\Controllers\API\V1\FamilyPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpPhysicalExamRequest;
use App\Models\V1\FamilyPlanning\PatientFp;
use App\Models\V1\FamilyPlanning\PatientFpHistory;
use App\Models\V1\FamilyPlanning\PatientFpPhysicalExam;
use App\Models\V1\GenderBasedViolence\PatientGbv;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientFpPhysicalExamController extends Controller
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
    public function store(PatientFpPhysicalExamRequest $request): JsonResponse
    {
       DB::transaction(function () use ($request) {

            $physicalExam = $request->input('physical_exam');

            PatientFpPhysicalExam::query()
                ->where('patient_id', $request->safe()->patient_id)->forceDelete();

            foreach ($physicalExam as $value) {
                PatientFpPhysicalExam::updateOrCreate(['patient_fp_id' => $request->patient_fp_id, 'patient_id' => $request->patient_id, 'pe_id' => $value['pe_id']],
                    $value);
            }
           PatientFp::where('patient_id', $request->patient_id)
               ->update(['pe_remarks' => $request->input('pe_remarks')]);
        });

        return response()->json([
            'message' => 'Physical Exam Successfully Saved',
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
