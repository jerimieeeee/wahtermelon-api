<?php

namespace App\Http\Controllers\API\V1\FamilyPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\FamilyPlanning\PatientFpPelvicExamRequest;
use App\Models\V1\FamilyPlanning\PatientFpHistory;
use App\Models\V1\FamilyPlanning\PatientFpPelvicExam;
use Illuminate\Http\Request;

class PatientFpPelvicExamController extends Controller
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
    public function store(PatientFpPelvicExamRequest $request)
    {
        $pelvicExam = $request->input('pelvic_exam');

        PatientFpPelvicExam::query()
            ->where('patient_id', $request->safe()->patient_id)->forceDelete();

        foreach ($pelvicExam as $value) {
            PatientFpPelvicExam::updateOrCreate(['patient_fp_id' => $request->patient_fp_id, 'patient_id' => $request->patient_id, 'pelvic_exam_code' => $value['pelvic_exam_code']],
                $value);
        }

        return response()->json([
            'message' => 'Pelvic Exam Successfully Saved',
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
