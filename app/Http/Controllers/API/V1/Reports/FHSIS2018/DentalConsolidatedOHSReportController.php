<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Dental\DentalConsolidatedOHSReportService;
use Illuminate\Http\Request;

class DentalConsolidatedOHSReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DentalConsolidatedOHSReportService $dentalConsolidated)
    {
        $part1 = $dentalConsolidated->get_dental_consolidated_report($request)->get();


        //TOOTH CONDITION
        $part2 = $dentalConsolidated->get_tooth_condition($request)->get();

        return [
            'data' => $part1[0],
            'adult_tooth_condition'  => $part2[0]
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
