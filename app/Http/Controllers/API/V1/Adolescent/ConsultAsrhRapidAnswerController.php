<?php

namespace App\Http\Controllers\API\V1\Adolescent;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Adolescent\ConsultAsrhRapidAnswerRequest;
use App\Models\V1\Adolescent\ConsultAsrhRapidAnswer;
use Illuminate\Http\Request;

class ConsultAsrhRapidAnswerController extends Controller
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
    public function store(ConsultAsrhRapidAnswerRequest $request)
    {
        $validatedData = $request->validated();
        foreach ($validatedData['answers'] as $answer) {
            $consultAsrhRapidAnswer = ConsultAsrhRapidAnswer::updateOrCreate(
                [
                'patient_id' => $validatedData['patient_id'],
                'consult_asrh_rapid_id' => $answer['consult_asrh_rapid_id'],
                'lib_rapid_questionnaire_id' => $answer['lib_rapid_questionnaire_id']
                ],
                $answer
            );
        }

        return response()->json([
            'message' => 'Consult ASRH Rapid Answer created successfully',
            'data' => $validatedData
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
