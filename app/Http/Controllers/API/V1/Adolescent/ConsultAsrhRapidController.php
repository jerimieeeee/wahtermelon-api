<?php

namespace App\Http\Controllers\API\V1\Adolescent;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Adolescent\ConsultAsrhRapidRequest;
use App\Models\V1\Adolescent\ConsultAsrhRapid;
use Illuminate\Http\Request;

class ConsultAsrhRapidController extends Controller
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
    public function store(ConsultAsrhRapidRequest $request)
    {
        $validatedData = $request->validated();
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
