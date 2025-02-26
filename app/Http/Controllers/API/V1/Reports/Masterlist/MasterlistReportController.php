<?php

namespace App\Http\Controllers\API\V1\Reports\Masterlist;

use App\Http\Controllers\Controller;
use App\Services\Childcare\ChildCareReportService;
use App\Services\Masterlist\MasterlistReportService;
use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group FHSIS Reports 2018
 *
 * APIs for managing Child Care Report Information
 *
 * @subgroup M1 Child Care Report
 *
 * @subgroupDescription M1 FHSIS 2018 Child Care Report.
 */
class MasterlistReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     */
    public function index(Request $request, MasterlistReportService $masterlistReportService)
    {
        // Number of items per page
        $perPage = 50; // You can change this value as needed

        // Maternal Care
        if ($request->program === 'mc') {
            // If the condition is true, fetch the data
            $query = $masterlistReportService->get_maternal_care_master_list($request);

            // Paginate the results
            $masterlist = $query->paginate($perPage);
        }

        // Family Planning
        if ($request->program === 'fp') {
            // If the condition is true, fetch the data
            $query = $masterlistReportService->get_fp_method_master_list($request);

            // Paginate the results
            $masterlist = $query->paginate($perPage);
        }

        // Blood Type
        if ($request->program === 'bt') {
            // If the condition is true, fetch the data
            $query = $masterlistReportService->get_bloodtype_master_list($request);

            // Paginate the results
            $masterlist = $query->paginate($perPage);
        }

        // Return the paginated results
        return $masterlist;
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
