<?php

namespace App\Http\Controllers\API\V1\Reports\Masterlist;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Reports\MasterlistResource;
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
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        // Map the program code to the corresponding method
        $methods = [
            'mc' => 'get_maternal_care_master_list',
            'fp' => 'get_fp_method_master_list',
            'bt' => 'get_bloodtype_master_list',
            'sn' => 'get_senior_masterlist',
        ];

        // Determine the method to call based on the requested program
        $method = $methods[$request->program] ?? null;

        if ($method) {
            $query = $masterlistReportService->$method($request);

            return $perPage === 'all'
                ? MasterlistResource::collection($query->get())
                : MasterlistResource::collection($query->paginate($perPage)->withQueryString());
        }
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
