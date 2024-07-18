<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Dental\DentalReportService;
use Illuminate\Http\Request;

class DentalReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DentalReportService $dentalReportService)
    {
        $dental = $dentalReportService->get_ab_post_exp_prophylaxis($request)->get();

        $male_dental_dmft = $dentalReportService->get_patient_dmft($request, 'M')->get();
        $female_dental_dmft = $dentalReportService->get_patient_dmft($request, 'F')->get();

        return [
            'data' => $dental[0],  // Extracting the contents of $dental[0]
            'male_dental_dmft' => $male_dental_dmft,
            'female_dental_dmft' => $female_dental_dmft
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
