<?php

namespace App\Http\Controllers\API\V1\Reports\DOH;

use App\Http\Controllers\Controller;
use App\Services\DailyService\DailyServiceReportService;
use Illuminate\Http\Request;

class DailyServiceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DailyServiceReportService $dailyServiceReportService)
    {
        $re = $dailyServiceReportService->get_daily_service($request);

        return $re;

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
