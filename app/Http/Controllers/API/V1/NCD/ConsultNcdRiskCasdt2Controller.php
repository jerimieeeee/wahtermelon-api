<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\ConsultNcdRiskCasdt2Request;
use App\Models\V1\Dental\DentalService;
use App\Models\V1\NCD\ConsultNcdRiskCasdt2;
use App\Models\V1\NCD\ConsultNcdRiskCasdt2Vision;
use App\Models\V1\NCD\PatientNcd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultNcdRiskCasdt2Controller extends Controller
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
    public function store(ConsultNcdRiskCasdt2Request $request)
    {
        DB::transaction(function() use ($request) {

            $eyecomplaint = $request->input('complaint');

            $data = ConsultNcdRiskCasdt2::updateOrCreate([

                'consult_ncd_risk_id' => $request->consult_ncd_risk_id,
                'patient_ncd_id' => $request->patient_ncd_id,
                'consult_id' => $request->consult_id,
                'patient_id' => $request->patient_id

            ], $request->validated());

            ConsultNcdRiskCasdt2Vision::query()
                ->where('patient_id', $data->patient_id)
                ->where('casdt2_id', $data->id)
                ->delete();

            foreach ($eyecomplaint as $value) {
                ConsultNcdRiskCasdt2Vision::updateOrCreate([
                    'casdt2_id' => $data->id,
                    'patient_id' => $data->patient_id,
                    'eye_complaint' => $value['eye_complaint'],
                ], $value);
            }
        });

        return response()->json([
            'message' => 'Casdt2 Successfully Saved',
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
