<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
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
class ChildCareReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     */
    public function index(Request $request, ChildCareReportService $childCareReportService, CategoryFilterService $categoryFilterService)
    {
        //Projected Population
        $projected_population = $categoryFilterService->get_projected_population()->get();

       //CPAB
        $cpab = $childCareReportService->get_cpab($request)->get();

        //CC Vaccines
        $cc_vaccines = $childCareReportService->get_vaccines($request)->get();

        //FIC_CIC
        $fic_cic = $childCareReportService->get_fic_cic($request)->get();

        //Init Breastfeeding
        $init_bfed = $childCareReportService->init_breastfeeding($request)->get();

        //ccdev_services
        $ccdev_services = $childCareReportService->get_ccdev_services($request)->get();

        //bfed
        $bfed = $childCareReportService->get_bfed($request)->get();

        //vitals
        $vitals = $childCareReportService->get_vitals($request)->get();

        //deworming
        $deworming = $childCareReportService->get_deworming($request)->get();

         //sick_infant_children
        $sick_infant_children = $childCareReportService->get_sick_infant_children($request)->get();

        //sick_infant_children_with_meds
        $sick_infant_children_with_meds = $childCareReportService->get_sick_infant_children_with_meds($request)->get();

        return [
            'projected_population' => $projected_population,
            'data' => [
                'cpab' => $cpab,
                'vaccines' => $cc_vaccines,
                'fic_cic' => $fic_cic,
                'init_bfed' => $init_bfed,
                'ccdev_services' => $ccdev_services,
                'bfed' => $bfed,
                'vitals' => $vitals,
                'deworm' => $deworming,
                'sick_infant_children' => $sick_infant_children,
                'sick_infant_children_with_meds' => $sick_infant_children_with_meds,
            ]
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
