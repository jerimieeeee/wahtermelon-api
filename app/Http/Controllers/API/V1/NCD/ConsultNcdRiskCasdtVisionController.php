<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\ConsultNcdRiskCasdtVisionRequest;
use App\Models\V1\NCD\ConsultNcdRiskCasdtVision;
use Illuminate\Http\Request;

class ConsultNcdRiskCasdtVisionController extends Controller
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
    public function store(ConsultNcdRiskCasdtVisionRequest $request)
    {
        $casdtvision = $request->input('casdt');

        ConsultNcdRiskCasdtVision::query()
            ->where('patient_id', $request->safe()->patient_id)
            ->where('patient_ncd_id', $request->safe()->patient_ncd_id)
            ->where('consult_ncd_risk_id', $request->safe()->consult_ncd_risk_id)
            ->delete();

        foreach ($casdtvision as $value) {
            ConsultNcdRiskCasdtVision::updateOrCreate([
                'consult_ncd_risk_id' => $request->consult_ncd_risk_id,
                'patient_ncd_id' => $request->patient_ncd_id,
                'consult_id' => $request->consult_id,
                'patient_id' => $request->patient_id,
                'eye_complaint' => $value['eye_complaint'],
                ],

                ['eye_refer' => $request->input('eye_refer'),
                'unaided' => $request->input('unaided'),
                'pinhole' => $request->input('pinhole'),
                'improved' => $request->input('improved'),
                'aided' => $request->input('aided'),
                'eye_refer_prof' => $request->input('eye_refer_prof'),
                ]
                + $value);
        }

        return response()->json([
            'message' => 'Casdt Vision Successfully Saved',
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
