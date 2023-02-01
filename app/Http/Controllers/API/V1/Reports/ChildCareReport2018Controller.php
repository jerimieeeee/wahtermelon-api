<?php

namespace App\Http\Controllers\API\V1\Reports;

use App\Http\Controllers\Controller;
use App\Models\V1\Patient\PatientVaccine;
use App\Services\Childcare\ChildCareReportService;
use Illuminate\Http\Request;

class ChildCareReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(Request $request, ChildCareReportService $childCareReportService): array
    {
        //CPAB
        $cpab_m =  $childCareReportService->get_cpab($request, 'M')->get();
        $cpab_f =  $childCareReportService->get_cpab($request, 'F')->get();

        //BCG
        $bcg_m =  $childCareReportService->get_vaccines($request, 'BCG', '1', 'M')->get();
        $bcg_f =  $childCareReportService->get_vaccines($request, 'BCG', '1', 'F')->get();

        //PENTA
        $penta1_m =  $childCareReportService->get_vaccines($request, 'PENTA', '1', 'M')->get();
        $penta1_f =  $childCareReportService->get_vaccines($request, 'PENTA', '1', 'F')->get();
        $penta2_m =  $childCareReportService->get_vaccines($request, 'PENTA', '2', 'M')->get();
        $penta2_f =  $childCareReportService->get_vaccines($request, 'PENTA', '2', 'F')->get();
        $penta3_m =  $childCareReportService->get_vaccines($request, 'PENTA', '3', 'M')->get();
        $penta3_f =  $childCareReportService->get_vaccines($request, 'PENTA', '3', 'F')->get();

        //OPV
        $opv1_m =  $childCareReportService->get_vaccines($request, 'OPV', '1', 'M')->get();
        $opv1_f =  $childCareReportService->get_vaccines($request, 'OPV', '1', 'F')->get();
        $opv2_m =  $childCareReportService->get_vaccines($request, 'OPV', '2', 'M')->get();
        $opv2_f =  $childCareReportService->get_vaccines($request, 'OPV', '2', 'F')->get();
        $opv3_m =  $childCareReportService->get_vaccines($request, 'OPV', '3', 'M')->get();
        $opv3_f =  $childCareReportService->get_vaccines($request, 'OPV', '3', 'F')->get();

        //PCV
        $pcv1_m =  $childCareReportService->get_vaccines($request, 'PCV', '1', 'M')->get();
        $pcv1_f =  $childCareReportService->get_vaccines($request, 'PCV', '1', 'F')->get();
        $pcv2_m =  $childCareReportService->get_vaccines($request, 'PCV', '2', 'M')->get();
        $pcv2_f =  $childCareReportService->get_vaccines($request, 'PCV', '2', 'F')->get();
        $pcv3_m =  $childCareReportService->get_vaccines($request, 'PCV', '3', 'M')->get();
        $pcv3_f =  $childCareReportService->get_vaccines($request, 'PCV', '3', 'F')->get();

        //MCV
        $mcv1_m =  $childCareReportService->get_vaccines($request, 'MCV', '1', 'M')->get();
        $mcv1_f =  $childCareReportService->get_vaccines($request, 'MCV', '1', 'F')->get();
        $mcv2_m =  $childCareReportService->get_vaccines($request, 'MCV', '2', 'M')->get();
        $mcv2_f =  $childCareReportService->get_vaccines($request, 'MCV', '2', 'F')->get();

        //TDRGR1
        $tdrgr1_m =  $childCareReportService->get_vaccines($request, 'TDRGR1', '1', 'M')->get();
        $tdrgr1_f =  $childCareReportService->get_vaccines($request, 'TDRGR1', '1', 'F')->get();

        //MRGR1
        $mrgr1_m =  $childCareReportService->get_vaccines($request, 'MRGR', '1', 'M')->get();
        $mrgr1_f =  $childCareReportService->get_vaccines($request, 'MRGR', '1', 'F')->get();

        //TDRGR7
        $tdrgr7_m =  $childCareReportService->get_vaccines($request, 'TDRGR7', '1', 'M')->get();
        $tdrgr7_f =  $childCareReportService->get_vaccines($request, 'TDRGR7', '1', 'F')->get();

        //MRGR7
        $mrgr7_m =  $childCareReportService->get_vaccines($request, 'MRGR7', '1', 'M')->get();
        $mrgr7_f =  $childCareReportService->get_vaccines($request, 'MRGR7', '1', 'F')->get();

        //HEPB within 24hrs
        $hepb_m_0 =  $childCareReportService->get_hepb($request, 'M', 0)->get();
        $hepb_f_0 =  $childCareReportService->get_hepb($request, 'F', 0)->get();

        //HEPB after 24hrs
        $hepb_m_2 =  $childCareReportService->get_hepb($request, 'M', 2)->get();
        $hepb_f_2 =  $childCareReportService->get_hepb($request, 'F', 2)->get();

        return [
            //CPAB
            'CPAB_Male' => $cpab_m,
            'CPAB_Female' => $cpab_f,

            //BCG
            'BCG_Male' => $bcg_m,
            'BCG_Female' => $bcg_f,

            //PENTA
            'PENTA1_Male' => $penta1_m,
            'PENTA1_Female' => $penta1_f,

            'PENTA2_Male' => $penta2_m,
            'PENTA2_Female' => $penta2_f,

            'PENTA3_Male' => $penta3_m,
            'PENTA3_Female' => $penta3_f,

            //OPV
            'OPV1_Male' => $opv1_m,
            'OPV1_Female' => $opv1_f,
            'OPV2_Male' => $opv2_m,
            'OPV2_Female' => $opv2_f,
            'OPV3_Male' => $opv3_m,
            'OPV3_Female' => $opv3_f,

            //PCV
            'PCV1_Male' => $pcv1_m,
            'PCV1_Female' => $pcv1_f,

            'PCV2_Male' => $pcv2_m,
            'PCV2_Female' => $pcv2_f,

            'PCV3_Male' => $pcv3_m,
            'PCV3_Female' => $pcv3_f,

            //MCV
            'MCV1_Male' => $mcv1_m,
            'MCV1_Female' => $mcv1_f,

            'MCV2_Male' => $mcv2_m,
            'MCV2_Female' => $mcv2_f,

            //TDRGR1
            'TDRGR1_Male' => $tdrgr1_m,
            'TDRGR1_Female' => $tdrgr1_f,

            //MRGR1
            'MRGR1_Male' => $mrgr1_m,
            'MRGR1_Female' => $mrgr1_f,

            //TDRGR7
            'TDRGR7_Male' => $tdrgr7_m,
            'TDRGR7_Female' => $tdrgr7_f,

            //MRGR7
            'MRGR7_Male' => $mrgr7_m,
            'MRGR7_Female' => $mrgr7_f,

            //HEPB within 24hrs
            'HEPB_Male_within_24' => $hepb_m_0,
            'HEPB_Female_within_24' => $hepb_f_0,

            //HEPB after 24hrs
            'HEPB_Male_after_24' => $hepb_m_2,
            'HEPB_Female_after_24' => $hepb_f_2,
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
     * @param  \Illuminate\Http\Request  $request
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
