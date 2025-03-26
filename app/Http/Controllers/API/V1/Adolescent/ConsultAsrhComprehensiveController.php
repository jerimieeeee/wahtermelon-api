<?php

namespace App\Http\Controllers\API\V1\Adolescent;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Adolescent\ConsultAsrhComprehensiveRequest;
use App\Http\Resources\API\V1\Adolescent\ConsultAsrhComprehensiveResource;
use App\Models\V1\Adolescent\ConsultAsrhComprehensive;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ConsultAsrhComprehensiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(ConsultAsrhComprehensive::class)
                ->with('consultRapid')
                ->defaultSort('assessment_date')
                ->allowedSorts('assessment_date')
                ->get();
        return ConsultAsrhComprehensiveResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsultAsrhComprehensiveRequest $request)
    {
        $validatedData = $request->validated();
        if ($validatedData['done_flag'] == 0) {
            $validatedData['done_date'] = null;
        }

        if ($validatedData['consent_flag'] == 0) {
            $validatedData['lib_asrh_consent_type_id'] = null;
            $validatedData['consent_type_other'] = null;
        }

        if ($validatedData['refused_flag'] == 0) {
            $validatedData['lib_asrh_refusal_reason_id'] = null;
            $validatedData['refusal_reason_other'] = null;
        }

        if (array_key_exists('lib_asrh_refusal_reason_id', $validatedData) && $validatedData['lib_asrh_refusal_reason_id'] != 99) {
            $validatedData['refusal_reason_other'] = null;
        }

        if (array_key_exists('lib_asrh_consent_type_id', $validatedData) && $validatedData['lib_asrh_consent_type_id'] != 99) {
            $validatedData['consent_type_other'] = null;
        }

        $consultAsrhComprehensive = ConsultAsrhComprehensive::updateOrCreate(
            [
                'consult_asrh_rapid_id' => $validatedData['consult_asrh_rapid_id'],
            ],
            $validatedData
        );

        return response()->json([
            'message' => 'Consult ASRH Comprehensive created successfully',
            'data' => $consultAsrhComprehensive
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConsultAsrhComprehensive $consultAsrhComprehensive)
    {
        $data = QueryBuilder::for(ConsultAsrhComprehensive::class)
                ->with('consultRapid')
                ->where('id', $consultAsrhComprehensive->id)
                ->first();
        return new ConsultAsrhComprehensiveResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsultAsrhComprehensiveRequest $request, ConsultAsrhComprehensive $consultAsrhComprehensive)
    {
        $validatedData = $request->validated();
        if ($validatedData['done_flag'] == 0) {
            $validatedData['done_date'] = null;
        }

        if ($validatedData['consent_flag'] == 0) {
            $validatedData['lib_asrh_consent_type_id'] = null;
            $validatedData['consent_type_other'] = null;
        }

        if ($validatedData['refused_flag'] == 0) {
            $validatedData['lib_asrh_refusal_reason_id'] = null;
            $validatedData['refusal_reason_other'] = null;
        }

        if (array_key_exists('lib_asrh_refusal_reason_id', $validatedData) && $validatedData['lib_asrh_refusal_reason_id'] != 99) {
            $validatedData['refusal_reason_other'] = null;
        }

        if (array_key_exists('lib_asrh_consent_type_id', $validatedData) && $validatedData['lib_asrh_consent_type_id'] != 99) {
            $validatedData['consent_type_other'] = null;
        }

        $consultAsrhComprehensive->update($validatedData);

        return response()->json([
            'message' => 'Consult ASRH Comprehensive updated successfully',
            'data' => $consultAsrhComprehensive
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
