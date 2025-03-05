<?php

namespace App\Http\Controllers\API\V1\Adolescent;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Adolescent\ConsultAsrhRapidRequest;
use App\Http\Resources\API\V1\Adolescent\ConsultAsrhRapidResource;
use App\Models\V1\Adolescent\ConsultAsrhRapid;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ConsultAsrhRapidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = QueryBuilder::for(ConsultAsrhRapid::class)
            ->when($request->filled('patient_id'), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->with(['answers.question', 'comprehensive'])
            ->get()
            ->each(function($consultAsrhRapid) {
                $consultAsrhRapid->answers->each(function($answer) {
                    if ($answer->answer == 1) {
                        $answer->load('question.algorithm');
                    }
                });
            })
            ->sortBy('assessment_date');
        return ConsultAsrhRapidResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsultAsrhRapidRequest $request)
    {
        $validatedData = $request->validated();

        if ($validatedData['done_flag'] == 0) {
            $validatedData['done_date'] = null;
        }

        if ($validatedData['client_type'] == 'walk-in') {
            $validatedData['lib_asrh_client_type_code'] = null;
        }

        if (array_key_exists('lib_asrh_client_type_code', $validatedData) && $validatedData['lib_asrh_client_type_code'] != '99') {
            $validatedData['other_client_type'] = null;
        }

        $consultAsrhRapid = ConsultAsrhRapid::updateOrCreate(
            [
            'patient_id' => $validatedData['patient_id'],
            'assessment_date' => $validatedData['assessment_date']
            ],
            $validatedData
        );

        return response()->json([
            'message' => 'Consult ASRH Rapid created successfully',
            'data' => $consultAsrhRapid
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(ConsultAsrhRapid $consultAsrhRapid)
    {
        $data = QueryBuilder::for(ConsultAsrhRapid::class)
            ->with(['answers.question', 'comprehensive'])
            ->get()
            ->each(function($consultAsrhRapid) {
                $consultAsrhRapid->answers->each(function($answer) {
                    if ($answer->answer == 1) {
                        $answer->load('question.algorithm');
                    }
                });
            })
            ->where('id', $consultAsrhRapid->id)
            ->firstOrFail();

        return new ConsultAsrhRapidResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsultAsrhRapidRequest $request, ConsultAsrhRapid $consultAsrhRapid)
    {
        $validatedData = $request->validated();
        if ($validatedData['done_flag'] == 0) {
            $validatedData['done_date'] = null;
        }

        if ($validatedData['client_type'] == 'walk-in') {
            $validatedData['lib_asrh_client_type_code'] = null;
        }

        if (array_key_exists('lib_asrh_client_type_code', $validatedData) && $validatedData['lib_asrh_client_type_code'] != '99') {
            $validatedData['other_client_type'] = null;
        }

        if ($validatedData['refused_flag'] == 0) {
            $validatedData['lib_asrh_refusal_reason_id'] = null;
            $validatedData['refusal_reason_other'] = null;
        }

        $consultAsrhRapid->update($validatedData);

        return response()->json([
            'message' => 'Consult ASRH Rapid updated successfully',
            'data' => $consultAsrhRapid
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
