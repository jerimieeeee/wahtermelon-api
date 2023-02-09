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

        //HEPB within 24hrs
        $hepb_m_0 =  $childCareReportService->get_hepb($request, 'M', 0)->get();
        $hepb_f_0 =  $childCareReportService->get_hepb($request, 'F', 0)->get();

        //HEPB after 24hrs
        $hepb_m_2 =  $childCareReportService->get_hepb($request, 'M', 2)->get();
        $hepb_f_2 =  $childCareReportService->get_hepb($request, 'F', 2)->get();

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

        //IPV 1
        $ipv1_m =  $childCareReportService->get_ipv1($request, 'M')->get();
        $ipv1_f =  $childCareReportService->get_ipv1($request, 'F')->get();

        //IPV2 Routine
        $ipv2_r_m =  $childCareReportService->get_ipv2($request, 'M', 0)->get();
        $ipv2_r_f =  $childCareReportService->get_ipv2($request, 'F', 0)->get();

        //IPV2 Catch up
        $ipv2_c_m =  $childCareReportService->get_ipv2($request, 'M', 1)->get();
        $ipv2_c_f =  $childCareReportService->get_ipv2($request, 'F', 1)->get();

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

        //FIC
        $fic_m =  $childCareReportService->get_fic_cic($request, 'M', 'FIC')->get();
        $fic_f =  $childCareReportService->get_fic_cic($request, 'F', 'FIC')->get();

        //CIC
        $cic_m =  $childCareReportService->get_fic_cic($request, 'M', 'CIC')->get();
        $cic_f =  $childCareReportService->get_fic_cic($request, 'F', 'CIC')->get();

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

        //Initiated breastfeeding 90mins
        $init_bfed_m =  $childCareReportService->init_breastfeeding($request, 'M')->get();
        $init_bfed_f =  $childCareReportService->init_breastfeeding($request, 'F')->get();

        //Preterm/LBW Iron
        $preterm_iron_m =  $childCareReportService->get_lbw_iron($request, 'M', 1)->get();
        $preterm_iron_f =  $childCareReportService->get_lbw_iron($request, 'F', 1)->get();

        //VIT A 1st Dose
        $vit_a_1st_m =  $childCareReportService->get_vit_a_1st($request, 'M')->get();
        $vit_a_1st_f =  $childCareReportService->get_vit_a_1st($request, 'F')->get();

        //VIT A 2nd and 3rd Dose
        $vit_a_2nd_3rd_m =  $childCareReportService->get_vit_a_2nd_3rd($request, 'M')->get();
        $vit_a_2nd_3rd_f =  $childCareReportService->get_vit_a_2nd_3rd($request, 'F')->get();

        //DEWORMING 1-19 y/o
        $deworm_1_19_m =  $childCareReportService->get_deworming($request, 'M', 1, 19)->get();
        $deworm_1_19_f =  $childCareReportService->get_deworming($request, 'F', 1, 19)->get();

        //DEWORMING 1-4 y/o
        $deworm_1_4_m =  $childCareReportService->get_deworming($request, 'M', 1, 4)->get();
        $deworm_1_4_f =  $childCareReportService->get_deworming($request, 'F', 1, 4)->get();

        //DEWORMING 5-9 y/o
        $deworm_5_9_m =  $childCareReportService->get_deworming($request, 'M', 5, 9)->get();
        $deworm_5_9_f =  $childCareReportService->get_deworming($request, 'F', 5, 9)->get();

        //DEWORMING 10-19 y/o
        $deworm_10_19_m =  $childCareReportService->get_deworming($request, 'M', 10, 19)->get();
        $deworm_10_19_f =  $childCareReportService->get_deworming($request, 'F', 10, 19)->get();

        //Sick Infant 6-11 months
        $sick_infant_6_11_m =  $childCareReportService->get_sick_infant_children($request, 'M', 6, 11)->get();
        $sick_infant_6_11_f =  $childCareReportService->get_sick_infant_children($request, 'F', 6, 11)->get();

        //Sick Children 12-59 months
        $sick_children_12_59_m =  $childCareReportService->get_sick_infant_children($request, 'M', 12, 59)->get();
        $sick_children_12_59_f =  $childCareReportService->get_sick_infant_children($request, 'F', 12, 59)->get();

        //Pneumonia 0-59 months
        $pneumonia_0_59_Male =  $childCareReportService->get_diarrhea_pneumonia($request, 'PNEUMONIA', 'M')->get();
        $pneumonia_0_59_Female =  $childCareReportService->get_diarrhea_pneumonia($request, 'PNEUMONIA', 'F')->get();

        //MNP 6-11 months
        $mnp_6_11_Male =  $childCareReportService->get_mnp($request, 'MNP', 'M')->get();
        $mnp_6_11_Female =  $childCareReportService->get_mnp($request, 'MNP', 'F')->get();

        //MNP2 12-23 months
        $mnp2_12_23_Male =  $childCareReportService->get_mnp($request, 'MNP2', 'M')->get();
        $mnp2_12_23_Female =  $childCareReportService->get_mnp($request, 'MNP2', 'F')->get();

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

            //IPV1
            'IPV1_Male' => $ipv1_m,
            'IPV1_Female' => $ipv1_f,

            //IPV2 Routine
            'IPV2_Routine_Male' => $ipv2_r_m,
            'IPV2_Routine_Female' => $ipv2_r_f,

            //IPV2 Catch up
            'IPV2_Catch_up_Male' => $ipv2_c_m,
            'IPV2_Catch_up_Female' => $ipv2_c_f,

            //FIC
            'FIC_Male' => $fic_m,
            'FIC_Female' => $fic_f,

            //FIC
            'CIC_Male' => $cic_m,
            'CIC_Female' => $cic_f,

            //Initiated breastfeeding
            'Initiated_Breastfeeding_90mins_Male' => $init_bfed_m,
            'Initiated_Breastfeeding_90mins_Female' => $init_bfed_f,

            //Vitamin A 1st Dose
            '6_11_months_vit_a_Male' => $vit_a_1st_m,
            '6_11_months_vit_a_Female' => $vit_a_1st_f,

            //Vitamin A 2nd & 3rd Dose
            '12_59_months_vit_a_Male' => $vit_a_2nd_3rd_m,
            '12_59_months_vit_a_Female' => $vit_a_2nd_3rd_f,

            //Preterm/LBW Iron
            'preterm_iron_Male' => $preterm_iron_m,
            'preterm_iron_Female' => $preterm_iron_f,

            //DEWORMING 1-19 y/o
            'deworming_1_to_19_yo_Male' => $deworm_1_19_m,
            'deworming_1_to_19_yo_Female' => $deworm_1_19_f,

            //DEWORMING 1-4 y/o
            'deworming_1_to_4_yo_Male' => $deworm_1_4_m,
            'deworming_1_to_4_yo_Female' => $deworm_1_4_f,

            //DEWORMING 5-9 y/o
            'deworming_5_to_9_yo_Male' => $deworm_5_9_m,
            'deworming_5_to_9_yo_Female' => $deworm_5_9_f,

            //DEWORMING 10-19 y/o
            'deworming_10_to_19_yo_Male' => $deworm_10_19_m,
            'deworming_10_to_19_yo_Female' => $deworm_10_19_f,

            //Sick Infant 6-11 months
            'sick_infant_6_to_11_months_Male' => $sick_infant_6_11_m,
            'sick_infant_6_to_11_months_Female' => $sick_infant_6_11_f,

            //Sick Children 12-59 months
            'deworming_12_to_59_months_Male' => $sick_children_12_59_m,
            'deworming_12_to_59_months_Female' => $sick_children_12_59_f,

            //Pneumonia 0-59 months
            'pneumonia_0_59_months_Male' => $pneumonia_0_59_Male,
            'pneumonia_0_59_months_Female' => $pneumonia_0_59_Female,

            //MNP 6-11 months
            'mnp_6_11_months_Male' => $mnp_6_11_Male,
            'mnp_6_11_months_Female' => $mnp_6_11_Female,

            //MNP2 12-23 months
            'mnp2_12_23_months_Male' => $mnp2_12_23_Male,
            'mnp2_12_23_months_Female' => $mnp2_12_23_Female,


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
