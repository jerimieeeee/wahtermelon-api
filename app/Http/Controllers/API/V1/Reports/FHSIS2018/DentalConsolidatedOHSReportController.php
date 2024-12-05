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


        //ADULT TOOTH CONDITION
        $adult_tooth = $dentalConsolidated->get_adult_tooth_condition($request)->get();

        //TEMPORARY TOOTH CONDITION
        $temporary_tooth = $dentalConsolidated->get_temporary_tooth_condition($request)->get();

        //DENTAL SERVICES
        $dental_services = $dentalConsolidated->get_dental_services($request)->get();

        //TOOTH SERVICES
        $tooth_service = $dentalConsolidated->get_tooth_services($request)->get();

        //ATTENDED & EXAMINED
        $attended_examined = $dentalConsolidated->get_attended_examined($request)->get();

        return [
            'data' => $part1[0],
            'temporary_tooth_condition'  => $temporary_tooth[0],
            'adult_tooth_condition'  => $adult_tooth[0],
            'dental_services'  => $dental_services[0],
            'tooth_service'  => $tooth_service[0],
            'attended_examined'  => $attended_examined[0]
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
