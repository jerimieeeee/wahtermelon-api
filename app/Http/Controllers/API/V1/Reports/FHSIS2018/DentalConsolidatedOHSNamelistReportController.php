<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Dental\DentalConsolidatedOHSNamelistService;
use Illuminate\Http\Request;

class DentalConsolidatedOHSNamelistReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DentalConsolidatedOHSNamelistService $namelistService)
    {
//        $part1 = $namelistService->get_medical_hx($request)->get();
        $temporary_tooth = $namelistService->get_temporary_tooth_condition($request)->get();
//        $adult_tooth = $namelistService->get_adult_tooth_condition($request)->get();
//        $services = $namelistService->get_dental_services($request)->get();


        return [
//            'data' => $part1,
            'temporary_tooth' => $temporary_tooth,
//            'adult_tooth' => $adult_tooth,
//            'services' => $services
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
