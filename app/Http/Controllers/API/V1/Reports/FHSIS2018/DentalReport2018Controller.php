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

        return $dental;
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
