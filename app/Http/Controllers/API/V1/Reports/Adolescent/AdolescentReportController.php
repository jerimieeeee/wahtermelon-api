<?php

namespace App\Http\Controllers\API\V1\Reports\Adolescent;

use App\Http\Controllers\Controller;
use App\Services\Adolescent\AdolescentReportService;
use Illuminate\Http\Request;

class AdolescentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AdolescentReportService $adolescentReportService)
    {
        $report = $adolescentReportService->get_adolescent_report($request)->get();

        return $report;

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
