<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Childcare\ChildCareReportNameListService;
use App\Services\Childcare\ChildCareReportService;
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
class ChildCareReport2018NamelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     */
    public function index(Request $request, ChildCareReportNameListService $nameListService)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $data = null;

        //Return Vaccines
        if (in_array($request->indicator, [
                'BCG',
                'HEPB',
                'HEPBV',
                'PENTA',
                'OPV',
                'IPV',
                'PCV',
                'MCV',
                'TDGR1',
                'MRGR',
                'TDGR7',
                'MRGR7',
            ])
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_vaccines_report_namelist($request);

            $data = $query->get();
        }

        //Breastfed
        if (in_array($request->indicator, [
            'male_init_bfed',
            'female_init_bfed',
            'male_female_init_bfed',
        ])
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->init_breastfeeding($request);

            $data = $query->get();
        }

        // Check if search term is provided
        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            // Split the search term by space
            $keywords = explode(' ', $searchTerm);

            // Filter the namelist collection based on each keyword
            $filteredNamelist = $data->filter(function ($item) use ($keywords) {
                foreach ($keywords as $keyword) {
                    if (stripos($item->last_name, $keyword) !== false ||
                        stripos($item->middle_name, $keyword) !== false ||
                        stripos($item->first_name, $keyword) !== false) {
                        return true;
                    }
                }
                return false;
            });
        } else {
            // If no search term provided, use the original namelist
            $filteredNamelist = $data;
        }

        // Count the total number of items in the filtered namelist
        $totalItems = $filteredNamelist->count();

        // Calculate the last page
        $lastPage = ceil($totalItems / $perPage);

        // Paginate the filtered namelist
        $page = $request->has('page') ? $request->input('page') : 1;
        $offset = ($page - 1) * $perPage;
        $data = $filteredNamelist->slice($offset, $perPage)->values();

        return [
            'current_page' => $page,
            'last_page' => $lastPage,
            'data' => $data,
        ];
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
