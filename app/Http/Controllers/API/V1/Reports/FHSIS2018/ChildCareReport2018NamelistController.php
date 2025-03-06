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

        //CPAB
        if ($request->indicator == 'cpab') {
            // If the condition is true, fetch the data
            $query = $nameListService->get_cpab_namelist($request);

            $data = $query->get();
        }

        //FIC & CIC
        if (in_array($request->indicator, [
            'fic',
            'cic'
        ])
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_fic_cic_namelist($request);

            $data = $query->get();
        }

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
            $query = $nameListService->init_breastfeeding_namelist($request);

            $data = $query->get();
        }

        //Vitals
        if (in_array($request->indicator, [
            'stunted',
            'wasted',
            'overweight_obese',
            'normal',
        ])
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_vitals_namelist($request);

            $data = $query->get();
        }

        //Childcare Services
        if (in_array($request->indicator, [
            'lbw_iron',
            'vit_a',
            'vit_a_2nd_3rd',
            'mnp',
            'mnp2',
        ])
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_ccdev_services_namelist($request);

            $data = $query->get();
        }

        //BFED
        if (in_array($request->indicator, [
            'ebf',
            'comp_fed',
            'comp_fed_stop_bfed'
        ])
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_bfed_namelist($request);

            $data = $query->get();
        }

        //DEWORMING
        if (in_array($request->indicator, [
            'deworming_1_to_19',
            'deworming_1_to_4',
            'deworming_5_to_49',
            'deworming_10_to_19'
        ])
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_deworming_namelist($request);

            $data = $query->get();
        }

        //SICK INFANT AND CHILDREN
        if (in_array($request->indicator, [
            'sick_infant',
            'sick_children',
            'diarrhea',
            'pneumonia'
        ])
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_sick_infant_children_namelist($request);

            $data = $query->get();
        }

        //SICK INFANT AND CHILDREN WITH MEDS
        if (in_array($request->indicator, [
            'sick_infant_with_vit_a',
            'sick_children_with_vit_a',
            'diarrhea_with_ors',
            'diarrhea_with_ors_zinc',
            'pneumonia_with_treatment'
        ])
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_sick_infant_children_with_meds_namelist($request);

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
        if (is_null($filteredNamelist)) {
            // Handle the case when $filteredNamelist is null
            $totalItems = 0;
        } else {
            $totalItems = $filteredNamelist->count();
        }

        // Calculate the last page
        $lastPage = ceil($totalItems / $perPage);

        // Paginate the filtered namelist
        $page = $request->has('page') ? $request->input('page') : 1;
        $offset = ($page - 1) * $perPage;

        $filteredNamelist = $filteredNamelist ?? collect();
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
