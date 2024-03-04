<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\FamilyPlanning\FamilyPlanningReportService;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group FHSIS Reports 2018
 *
 * APIs for managing Family Planning Report Information
 *
 * @subgroup M1 Family Planning Report
 *
 * @subgroupDescription M1 Family Planning Report.
 */
class FamilyPlanningReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     */
    public function index(Request $request, FamilyPlanningReportService $familyPlanningReportService)
    {
        //BTL NEW ACCEPTOR PREVIOUS MONTH
        $FSTRBTL_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'FSTRBTL', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $FSTRBTL_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'FSTRBTL', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $FSTRBTL_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'FSTRBTL', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //BTL OTHER ACCEPTOR PRESENT MONTH
        $FSTRBTL_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'FSTRBTL', '10', '14')->get();
        $FSTRBTL_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'FSTRBTL', '15', '19')->get();
        $FSTRBTL_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'FSTRBTL', '20', '49')->get();

        //BTL DROPOUT PRESENT MONTH
        $FSTRBTL_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'FSTRBTL', '10', '14')->get();
        $FSTRBTL_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'FSTRBTL', '15', '19')->get();
        $FSTRBTL_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'FSTRBTL', '20', '49')->get();

        //BTL NEW ACCEPTOR PRESENT MONTH
        $FSTRBTL_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'FSTRBTL', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $FSTRBTL_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'FSTRBTL', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $FSTRBTL_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'FSTRBTL', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //NSV NEW ACCEPTOR PREVIOUS MONTH
        $MSV_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'MSV', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $MSV_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'MSV', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $MSV_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'MSV', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //NSV OTHER ACCEPTOR PRESENT MONTH
        $MSV_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'MSV', '10', '14')->get();
        $MSV_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'MSV', '15', '19')->get();
        $MSV_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'MSV', '20', '49')->get();

        //NSV DROPOUT PRESENT MONTH
        $MSV_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'MSV', '10', '14')->get();
        $MSV_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'MSV', '15', '19')->get();
        $MSV_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'MSV', '20', '49')->get();

        //NSV NEW ACCEPTOR PRESENT MONTH
        $MSVL_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'MSV', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $MSV_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'MSV', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $MSV_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'MSV', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //CONDOM NEW ACCEPTOR PREVIOUS MONTH
        $CONDOM_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'CONDOM', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $CONDOM_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'CONDOM', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $CONDOM_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'CONDOM', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //CONDOM OTHER ACCEPTOR PRESENT MONTH
        $CONDOM_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'CONDOM', '10', '14')->get();
        $CONDOM_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'CONDOM', '15', '19')->get();
        $CONDOM_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'CONDOM', '20', '49')->get();

        //CONDOM DROPOUT PRESENT MONTH
        $CONDOM_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'CONDOM', '10', '14')->get();
        $CONDOM_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'CONDOM', '15', '19')->get();
        $CONDOM_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'CONDOM', '20', '49')->get();

        //CONDOM NEW ACCEPTOR PRESENT MONTH
        $CONDOM_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'CONDOM', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $CONDOM_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'CONDOM', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $CONDOM_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'CONDOM', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //IUD-I NEW ACCEPTOR PREVIOUS MONTH
        $IUD_I_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'IUD', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $IUD_I_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'IUD', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $IUD_I_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'IUD', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //IUD-I OTHER ACCEPTOR PRESENT MONTH
        $IUD_I_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'IUD', '10', '14')->get();
        $IUD_I_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'IUD', '15', '19')->get();
        $IUD_I_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'IUD', '20', '49')->get();

        //IUD-I DROPOUT PRESENT MONTH
        $IUD_I_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'IUD', '10', '14')->get();
        $IUD_I_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'IUD', '15', '19')->get();
        $IUD_I_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'IUD', '20', '49')->get();

        //IUD-I NEW ACCEPTOR PRESENT MONTH
        $IUD_I_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'IUD', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $IUD_I_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'IUD', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $IUD_I_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'IUD', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //IUD-P NEW ACCEPTOR PREVIOUS MONTH
        $IUD_P_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'IUDPP', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $IUD_P_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'IUDPP', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $IUD_P_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'IUDPP', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //IUD-P OTHER ACCEPTOR PRESENT MONTH
        $IUD_P_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'IUDPP', '10', '14')->get();
        $IUD_P_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'IUDPP', '15', '19')->get();
        $IUD_P_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'IUDPP', '20', '49')->get();

        //IUD-P DROPOUT PRESENT MONTH
        $IUD_P_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'IUDPP', '10', '14')->get();
        $IUD_P_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'IUDPP', '15', '19')->get();
        $IUD_P_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'IUDPP', '20', '49')->get();

        //IUD-P NEW ACCEPTOR PRESENT MONTH
        $IUD_P_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'IUDPP', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $IUD_P_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'IUDPP', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $IUD_P_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'IUDPP', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //PILLS-COC NEW ACCEPTOR PREVIOUS MONTH
        $PILLS_COC_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'PILLS', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $PILLS_COC_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'PILLS', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $PILLS_COC_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'PILLS', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //PILLS-COC OTHER ACCEPTOR PRESENT MONTH
        $PILLS_COC_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'PILLS', '10', '14')->get();
        $PILLS_COC_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'PILLS', '15', '19')->get();
        $PILLS_COC_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'PILLS', '20', '49')->get();

        //PILLS-COC DROPOUT PRESENT MONTH
        $PILLS_COC_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'PILLS', '10', '14')->get();
        $PILLS_COC_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'PILLS', '15', '19')->get();
        $PILLS_COC_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'PILLS', '20', '49')->get();

        //PILLS-COC NEW ACCEPTOR PRESENT MONTH
        $PILLS_COC_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'PILLS', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $PILLS_COC_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'PILLS', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $PILLS_COC_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'PILLS', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //PILLS-POP NEW ACCEPTOR PREVIOUS MONTH
        $PILLS_POP_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'PILLSPOP', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $PILLS_POP_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'PILLSPOP', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $PILLS_POP_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'PILLSPOP', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //PILLS-POP OTHER ACCEPTOR PRESENT MONTH
        $PILLS_POP_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'PILLSPOP', '10', '14')->get();
        $PILLS_POP_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'PILLSPOP', '15', '19')->get();
        $PILLS_POP_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'PILLSPOP', '20', '49')->get();

        //PILLS-POP DROPOUT PRESENT MONTH
        $PILLS_POP_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'PILLSPOP', '10', '14')->get();
        $PILLS_POP_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'PILLSPOP', '15', '19')->get();
        $PILLS_POP_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'PILLSPOP', '20', '49')->get();

        //PILLS-POP NEW ACCEPTOR PRESENT MONTH
        $PILLS_POP_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'PILLSPOP', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $PILLS_POP_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'PILLSPOP', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $PILLS_POP_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'PILLSPOP', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //DMPA NEW ACCEPTOR PREVIOUS MONTH
        $DMPA_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'DMPA', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $DMPA_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'DMPA', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $DMPA_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'DMPA', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //DMPA OTHER ACCEPTOR PRESENT MONTH
        $DMPA_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'DMPA', '10', '14')->get();
        $DMPA_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'DMPA', '15', '19')->get();
        $DMPA_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'DMPA', '20', '49')->get();

        //DMPA DROPOUT PRESENT MONTH
        $DMPA_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'DMPA', '10', '14')->get();
        $DMPA_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'DMPA', '15', '19')->get();
        $DMPA_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'DMPA', '20', '49')->get();

        //DMPA NEW ACCEPTOR PRESENT MONTH
        $DMPA_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'DMPA', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $DMPA_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'DMPA', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $DMPA_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'DMPA', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //IMPLANT NEW ACCEPTOR PREVIOUS MONTH
        $IMPLANT_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'IMPLANT', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $IMPLANT_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'IMPLANT', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $IMPLANT_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'IMPLANT', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //IMPLANT OTHER ACCEPTOR PRESENT MONTH
        $IMPLANT_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'IMPLANT', '10', '14')->get();
        $IMPLANT_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'IMPLANT', '15', '19')->get();
        $IMPLANT_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'IMPLANT', '20', '49')->get();

        //IMPLANT DROPOUT PRESENT MONTH
        $IMPLANT_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'IMPLANT', '10', '14')->get();
        $IMPLANT_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'IMPLANT', '15', '19')->get();
        $IMPLANT_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'IMPLANT', '20', '49')->get();

        //IMPLANT NEW ACCEPTOR PRESENT MONTH
        $IMPLANT_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'IMPLANT', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $IMPLANT_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'IMPLANT', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $IMPLANT_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'IMPLANT', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //NFPCM NEW ACCEPTOR PREVIOUS MONTH
        $NFPCM_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'NFPCM', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $NFPCM_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'NFPCM', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $NFPCM_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'NFPCM', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //NFPCM OTHER ACCEPTOR PRESENT MONTH
        $NFPCM_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'NFPCM', '10', '14')->get();
        $NFPCM_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'NFPCM', '15', '19')->get();
        $NFPCM_other_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'NFPCM', '20', '49')->get();

        //NFPCM DROPOUT PRESENT MONTH
        $NFPCM_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'NFPCM', '10', '14')->get();
        $NFPCM_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'NFPCM', '15', '19')->get();
        $NFPCM_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'NFPCM', '20', '49')->get();

        //NFPCM NEW ACCEPTOR PRESENT MONTH
        $NFPCM_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'NFPCM', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $NFPCM_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'NFPCM', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $NFPCM_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'NFPCM', 'NA', '20', '49', 'NA-present-MONTH')->get();

        //NFPBBT NEW ACCEPTOR PREVIOUS MONTH
        $NFPBBT_new_acceptor_previous_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'NFPBBT', 'NA', '10', '14', 'NA-previous-MONTH')->get();
        $NFPBBT_new_acceptor_previous_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'NFPBBT', 'NA', '15', '19', 'NA-previous-MONTH')->get();
        $NFPBBT_new_acceptor_previous_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'NFPBBT', 'NA', '20', '49', 'NA-previous-MONTH')->get();

        //NFPBBT OTHER ACCEPTOR PRESENT MONTH
        $NFPBBT_other_acceptor_previous_month_10_14 = $familyPlanningReportService->other_acceptor($request, 'NFPBBT', '10', '14')->get();
        $NFPBBT_other_acceptor_previous_month_15_19 = $familyPlanningReportService->other_acceptor($request, 'NFPBBT', '15', '19')->get();
        $NFPBBTother_acceptor_previous_month_20_49 = $familyPlanningReportService->other_acceptor($request, 'NFPBBT', '20', '49')->get();

        //NFPBBT DROPOUT PRESENT MONTH
        $NFPBBT_dropout_present_month_10_14 = $familyPlanningReportService->dropout($request, 'NFPBBT', '10', '14')->get();
        $NFPBBT_dropout_present_month_15_19 = $familyPlanningReportService->dropout($request, 'NFPBBT', '15', '19')->get();
        $NFPBBT_dropout_present_month_20_49 = $familyPlanningReportService->dropout($request, 'NFPBBT', '20', '49')->get();

        //NFPBBT NEW ACCEPTOR PRESENT MONTH
        $NFPBBT_new_acceptor_present_month_10_14 = $familyPlanningReportService->new_acceptor($request, 'NFPBBT', 'NA', '10', '14', 'NA-present-MONTH')->get();
        $NFPBBT_new_acceptor_present_month_15_19 = $familyPlanningReportService->new_acceptor($request, 'NFPBBT', 'NA', '15', '19', 'NA-present-MONTH')->get();
        $NFPBBT_new_acceptor_present_month_20_49 = $familyPlanningReportService->new_acceptor($request, 'NFPBBT', 'NA', '20', '49', 'NA-present-MONTH')->get();


        $btl = [
            //BTL NEW ACCEPTOR PREVIOUS MONTH
            'FSTRBTL_new_acceptor_previous_month_10_14' => $FSTRBTL_new_acceptor_previous_month_10_14,
            'FSTRBTL_new_acceptor_previous_month_15_19' => $FSTRBTL_new_acceptor_previous_month_15_19,
            'FSTRBTL_new_acceptor_previous_month_20_49' => $FSTRBTL_new_acceptor_previous_month_20_49,

            //BTL OTHER ACCEPTOR PRESENT MONTH
            'FSTRBTL_other_acceptor_previous_month_10_14' => $FSTRBTL_other_acceptor_previous_month_10_14,
            'FSTRBTL_other_acceptor_previous_month_15_19' => $FSTRBTL_other_acceptor_previous_month_15_19,
            'FSTRBTL_other_acceptor_previous_month_20_49' => $FSTRBTL_other_acceptor_previous_month_20_49,

            //BTL DROPOUT PRESENT MONTH
            'FSTRBTL_dropout_present_month_10_14' => $FSTRBTL_dropout_present_month_10_14,
            'FSTRBTL_dropout_present_month_15_19' => $FSTRBTL_dropout_present_month_15_19,
            'FSTRBTL_dropout_present_month_20_49' => $FSTRBTL_dropout_present_month_20_49,

            //BTL NEW ACCEPTOR PRESENT MONTH
            'FSTRBTL_new_acceptor_present_month_10_14' => $FSTRBTL_new_acceptor_present_month_10_14,
            'FSTRBTL_new_acceptor_present_month_15_19' =>  $FSTRBTL_new_acceptor_present_month_15_19,
            'FSTRBTL_new_acceptor_present_month_20_49' =>  $FSTRBTL_new_acceptor_present_month_20_49,
        ];

        $msv = [
            //NSV NEW ACCEPTOR PREVIOUS MONTH
            'MSV_new_acceptor_previous_month_10_14' => $MSV_new_acceptor_previous_month_10_14,
            'MSV_new_acceptor_previous_month_15_19' => $MSV_new_acceptor_previous_month_15_19,
            'MSV_new_acceptor_previous_month_20_49' => $MSV_new_acceptor_previous_month_20_49,

            //NSV OTHER ACCEPTOR PRESENT MONTH
            'MSV_other_acceptor_previous_month_10_14' => $MSV_other_acceptor_previous_month_10_14,
            'MSV_other_acceptor_previous_month_15_19' => $MSV_other_acceptor_previous_month_15_19,
            'MSV_other_acceptor_previous_month_20_49' => $MSV_other_acceptor_previous_month_20_49,

            //NSV DROPOUT PRESENT MONTH
            'MSV_dropout_present_month_10_14' => $MSV_dropout_present_month_10_14,
            'MSV_dropout_present_month_15_19' => $MSV_dropout_present_month_15_19,
            'MSV_dropout_present_month_20_49' => $MSV_dropout_present_month_20_49,

            //NSV NEW ACCEPTOR PRESENT MONTH
            'MSVL_new_acceptor_present_month_10_14' => $MSVL_new_acceptor_present_month_10_14,
            'MSV_new_acceptor_present_month_15_19' => $MSV_new_acceptor_present_month_15_19,
            'MSV_new_acceptor_present_month_20_49' => $MSV_new_acceptor_present_month_20_49,
        ];

        $condom = [
            //CONDOM NEW ACCEPTOR PREVIOUS MONTH
            '$CONDOM_new_acceptor_previous_month_10_14' => $CONDOM_new_acceptor_previous_month_10_14,
            '$CONDOM_new_acceptor_previous_month_15_19' => $CONDOM_new_acceptor_previous_month_15_19,
            '$CONDOM_new_acceptor_previous_month_20_49' => $CONDOM_new_acceptor_previous_month_20_49,

            //CONDOM OTHER ACCEPTOR PRESENT MONTH
            '$CONDOM_other_acceptor_previous_month_10_14' => $CONDOM_other_acceptor_previous_month_10_14,
            '$CONDOM_other_acceptor_previous_month_15_19' => $CONDOM_other_acceptor_previous_month_15_19,
            '$CONDOM_other_acceptor_previous_month_20_49' => $CONDOM_other_acceptor_previous_month_20_49,

            //CONDOM DROPOUT PRESENT MONTH
            '$CONDOM_dropout_present_month_10_14' => $CONDOM_dropout_present_month_10_14,
            '$CONDOM_dropout_present_month_15_19' => $CONDOM_dropout_present_month_15_19,
            '$CONDOM_dropout_present_month_20_49' => $CONDOM_dropout_present_month_20_49,

            //CONDOM NEW ACCEPTOR PRESENT MONTH
            '$CONDOM_new_acceptor_present_month_10_14' => $CONDOM_new_acceptor_present_month_10_14,
            '$CONDOM_new_acceptor_present_month_15_19' => $CONDOM_new_acceptor_present_month_15_19,
            '$CONDOM_new_acceptor_present_month_20_49' => $CONDOM_new_acceptor_present_month_20_49,
        ];

        $iud_i = [
            //IUD-I NEW ACCEPTOR PREVIOUS MONTH
            'IUD_I_new_acceptor_previous_month_10_14' => $IUD_I_new_acceptor_previous_month_10_14,
            'IUD_I_new_acceptor_previous_month_15_19' => $IUD_I_new_acceptor_previous_month_15_19,
            'IUD_I_new_acceptor_previous_month_20_49' => $IUD_I_new_acceptor_previous_month_20_49,

            //IUD-I OTHER ACCEPTOR PRESENT MONTH
            'IUD_I_other_acceptor_previous_month_10_14' => $IUD_I_other_acceptor_previous_month_10_14,
            'IUD_I_other_acceptor_previous_month_15_19' => $IUD_I_other_acceptor_previous_month_15_19,
            'IUD_I_other_acceptor_previous_month_20_49' => $IUD_I_other_acceptor_previous_month_20_49,

            //IUD-I DROPOUT PRESENT MONTH
            'IUD_I_dropout_present_month_10_14' => $IUD_I_dropout_present_month_10_14,
            'IUD_I_dropout_present_month_15_19' => $IUD_I_dropout_present_month_15_19,
            'IUD_I_dropout_present_month_20_49' => $IUD_I_dropout_present_month_20_49,

            //IUD-I NEW ACCEPTOR PRESENT MONTH
            'IUD_I_new_acceptor_present_month_10_14' => $IUD_I_new_acceptor_present_month_10_14,
            'IUD_I_new_acceptor_present_month_15_19' => $IUD_I_new_acceptor_present_month_15_19,
            'IUD_I_new_acceptor_present_month_20_49' => $IUD_I_new_acceptor_present_month_20_49,
        ];

        $iud_pp = [
            //IUD-P NEW ACCEPTOR PREVIOUS MONTH
            'IUD_P_new_acceptor_previous_month_10_14' => $IUD_P_new_acceptor_previous_month_10_14,
            'IUD_P_new_acceptor_previous_month_15_19' => $IUD_P_new_acceptor_previous_month_15_19,
            'IUD_P_new_acceptor_previous_month_20_49' => $IUD_P_new_acceptor_previous_month_20_49,

            //IUD-P OTHER ACCEPTOR PRESENT MONTH
            'IUD_P_other_acceptor_previous_month_10_14' => $IUD_P_other_acceptor_previous_month_10_14,
            'IUD_P_other_acceptor_previous_month_15_19' => $IUD_P_other_acceptor_previous_month_15_19,
            'IUD_P_other_acceptor_previous_month_20_49' => $IUD_P_other_acceptor_previous_month_20_49,

            //IUD-P DROPOUT PRESENT MONTH
            'IUD_P_dropout_present_month_10_14' => $IUD_P_dropout_present_month_10_14,
            'IUD_P_dropout_present_month_15_19' => $IUD_P_dropout_present_month_15_19,
            'IUD_P_dropout_present_month_20_49' => $IUD_P_dropout_present_month_20_49,

            //IUD-P NEW ACCEPTOR PRESENT MONTH
            'IUD_P_new_acceptor_present_month_10_14' => $IUD_P_new_acceptor_present_month_10_14,
            'IUD_P_new_acceptor_present_month_15_19' => $IUD_P_new_acceptor_present_month_15_19,
            'IUD_P_new_acceptor_present_month_20_49' => $IUD_P_new_acceptor_present_month_20_49,
        ];

        $pills_coc = [
            //PILLS-COC NEW ACCEPTOR PREVIOUS MONTH
            'PILLS_COC_new_acceptor_previous_month_10_14' => $PILLS_COC_new_acceptor_previous_month_10_14,
            'PILLS_COC_new_acceptor_previous_month_15_19' => $PILLS_COC_new_acceptor_previous_month_15_19,
            'PILLS_COC_new_acceptor_previous_month_20_49' => $PILLS_COC_new_acceptor_previous_month_20_49,

            //PILLS-COC OTHER ACCEPTOR PRESENT MONTH
            'PILLS_COC_other_acceptor_previous_month_10_14' => $PILLS_COC_other_acceptor_previous_month_10_14,
            'PILLS_COC_other_acceptor_previous_month_15_19' => $PILLS_COC_other_acceptor_previous_month_15_19,
            'PILLS_COC_other_acceptor_previous_month_20_49' => $PILLS_COC_other_acceptor_previous_month_20_49,

            //PILLS-COC DROPOUT PRESENT MONTH
            'PILLS_COC_dropout_present_month_10_14' => $PILLS_COC_dropout_present_month_10_14,
            'PILLS_COC_dropout_present_month_15_19' => $PILLS_COC_dropout_present_month_15_19,
            'PILLS_COC_dropout_present_month_20_49' => $PILLS_COC_dropout_present_month_20_49,

            //PILLS-COC NEW ACCEPTOR PRESENT MONTH
            'PILLS_COC_new_acceptor_present_month_10_14' => $PILLS_COC_new_acceptor_present_month_10_14,
            'PILLS_COC_new_acceptor_present_month_15_19' => $PILLS_COC_new_acceptor_present_month_15_19,
            'PILLS_COC_new_acceptor_present_month_20_49' => $PILLS_COC_new_acceptor_present_month_20_49,
        ];

        $pills_pop = [
            //PILLS-POP NEW ACCEPTOR PREVIOUS MONTH
            'PILLS_POP_new_acceptor_previous_month_10_14' => $PILLS_POP_new_acceptor_previous_month_10_14,
            'PILLS_POP_new_acceptor_previous_month_15_19' => $PILLS_POP_new_acceptor_previous_month_15_19,
            'PILLS_POP_new_acceptor_previous_month_20_49' => $PILLS_POP_new_acceptor_previous_month_20_49,

            //PILLS-POP OTHER ACCEPTOR PRESENT MONTH
            'PILLS_POP_other_acceptor_previous_month_10_14' => $PILLS_POP_other_acceptor_previous_month_10_14,
            'PILLS_POP_other_acceptor_previous_month_15_19' => $PILLS_POP_other_acceptor_previous_month_15_19,
            'PILLS_POP_other_acceptor_previous_month_20_49' => $PILLS_POP_other_acceptor_previous_month_20_49,

            //PILLS-POP DROPOUT PRESENT MONTH
            'PILLS_POP_dropout_present_month_10_14' => $PILLS_POP_dropout_present_month_10_14,
            'PILLS_POP_dropout_present_month_15_19' => $PILLS_POP_dropout_present_month_15_19,
            'PILLS_POP_dropout_present_month_20_49' => $PILLS_POP_dropout_present_month_20_49,

            //PILLS-POP NEW ACCEPTOR PRESENT MONTH
            'PILLS_POP_new_acceptor_present_month_10_14' => $PILLS_POP_new_acceptor_present_month_10_14,
            'PILLS_POP_new_acceptor_present_month_15_19' => $PILLS_POP_new_acceptor_present_month_15_19,
            'PILLS_POP_new_acceptor_present_month_20_49' => $PILLS_POP_new_acceptor_present_month_20_49,
        ];

        $dmpa = [
            //DMPA NEW ACCEPTOR PREVIOUS MONTH
            'DMPA_new_acceptor_previous_month_10_14' => $DMPA_new_acceptor_previous_month_10_14,
            'DMPA_new_acceptor_previous_month_15_19' => $DMPA_new_acceptor_previous_month_15_19,
            'DMPA_new_acceptor_previous_month_20_49' => $DMPA_new_acceptor_previous_month_20_49,

            //DMPA OTHER ACCEPTOR PRESENT MONTH
            'DMPA_other_acceptor_previous_month_10_14' => $DMPA_other_acceptor_previous_month_10_14,
            'DMPA_other_acceptor_previous_month_15_19' => $DMPA_other_acceptor_previous_month_15_19,
            'DMPA_other_acceptor_previous_month_20_49' => $DMPA_other_acceptor_previous_month_20_49,

            //DMPA DROPOUT PRESENT MONTH
            'DMPA_dropout_present_month_10_14' => $DMPA_dropout_present_month_10_14,
            'DMPA_dropout_present_month_15_19' => $DMPA_dropout_present_month_15_19,
            'DMPA_dropout_present_month_20_49' => $DMPA_dropout_present_month_20_49,

            //DMPA NEW ACCEPTOR PRESENT MONTH
            'DMPA_new_acceptor_present_month_10_14' => $DMPA_new_acceptor_present_month_10_14,
            'DMPA_new_acceptor_present_month_15_19' => $DMPA_new_acceptor_present_month_15_19,
            'DMPA_new_acceptor_present_month_20_49' => $DMPA_new_acceptor_present_month_20_49,
        ];

        $implant = [
            //IMPLANT NEW ACCEPTOR PREVIOUS MONTH
            'IMPLANT_new_acceptor_previous_month_10_14' => $IMPLANT_new_acceptor_previous_month_10_14,
            'IMPLANT_new_acceptor_previous_month_15_19' => $IMPLANT_new_acceptor_previous_month_15_19,
            'IMPLANT_new_acceptor_previous_month_20_49' => $IMPLANT_new_acceptor_previous_month_20_49,

            //IMPLANT OTHER ACCEPTOR PRESENT MONTH
            'IMPLANT_other_acceptor_previous_month_10_14' => $IMPLANT_other_acceptor_previous_month_10_14,
            'IMPLANT_other_acceptor_previous_month_15_19' => $IMPLANT_other_acceptor_previous_month_15_19,
            'IMPLANT_other_acceptor_previous_month_20_49' => $IMPLANT_other_acceptor_previous_month_20_49,

            //IMPLANT DROPOUT PRESENT MONTH
            'IMPLANT_dropout_present_month_10_14' => $IMPLANT_dropout_present_month_10_14,
            'IMPLANT_dropout_present_month_15_19' => $IMPLANT_dropout_present_month_15_19,
            'IMPLANT_dropout_present_month_20_49' => $IMPLANT_dropout_present_month_20_49,

            //IMPLANT NEW ACCEPTOR PRESENT MONTH
            'IMPLANT_new_acceptor_present_month_10_14' => $IMPLANT_new_acceptor_present_month_10_14,
            'IMPLANT_new_acceptor_present_month_15_19' => $IMPLANT_new_acceptor_present_month_15_19,
            'IMPLANT_new_acceptor_present_month_20_49' => $IMPLANT_new_acceptor_present_month_20_49,

            ];

        $nfpcm = [
            //NFPCM NEW ACCEPTOR PREVIOUS MONTH
            'NFPCM_new_acceptor_previous_month_10_14' => $NFPCM_new_acceptor_previous_month_10_14,
            'NFPCM_new_acceptor_previous_month_15_19' => $NFPCM_new_acceptor_previous_month_15_19,
            'NFPCM_new_acceptor_previous_month_20_49' => $NFPCM_new_acceptor_previous_month_20_49,

            //NFPCM OTHER ACCEPTOR PRESENT MONTH
            'NFPCM_other_acceptor_previous_month_10_14' => $NFPCM_other_acceptor_previous_month_10_14,
            'NFPCM_other_acceptor_previous_month_15_19' => $NFPCM_other_acceptor_previous_month_15_19,
            'NFPCM_other_acceptor_previous_month_20_49' => $NFPCM_other_acceptor_previous_month_20_49,

            //NFPCM DROPOUT PRESENT MONTH
            'NFPCM_dropout_present_month_10_14' => $NFPCM_dropout_present_month_10_14,
            'NFPCM_dropout_present_month_15_19' => $NFPCM_dropout_present_month_15_19,
            'NFPCM_dropout_present_month_20_49' => $NFPCM_dropout_present_month_20_49,

            //NFPCM NEW ACCEPTOR PRESENT MONTH
            'NFPCM_new_acceptor_present_month_10_14' => $NFPCM_new_acceptor_present_month_10_14,
            'NFPCM_new_acceptor_present_month_15_19' => $NFPCM_new_acceptor_present_month_15_19,
            'NFPCM_new_acceptor_present_month_20_49' => $NFPCM_new_acceptor_present_month_20_49,
        ];

        $nfpbbt = [
            //NFPBBT NEW ACCEPTOR PREVIOUS MONTH
            'NFPBBT_new_acceptor_previous_month_10_14' => $NFPBBT_new_acceptor_previous_month_10_14,
            'NFPBBT_new_acceptor_previous_month_15_19' => $NFPBBT_new_acceptor_previous_month_15_19,
            'NFPBBT_new_acceptor_previous_month_20_49' => $NFPBBT_new_acceptor_previous_month_20_49,

            //NFPBBT OTHER ACCEPTOR PRESENT MONTH
            'NFPBBT_other_acceptor_previous_month_10_14' => $NFPBBT_other_acceptor_previous_month_10_14,
            'NFPBBT_other_acceptor_previous_month_15_19' => $NFPBBT_other_acceptor_previous_month_15_19,
            'NFPBBTother_acceptor_previous_month_20_49' => $NFPBBTother_acceptor_previous_month_20_49,

            //NFPBBT DROPOUT PRESENT MONTH
            'NFPBBT_dropout_present_month_10_14' => $NFPBBT_dropout_present_month_10_14,
            'NFPBBT_dropout_present_month_15_19' => $NFPBBT_dropout_present_month_15_19,
            'NFPBBT_dropout_present_month_20_49' => $NFPBBT_dropout_present_month_20_49,

            //NFPBBT NEW ACCEPTOR PRESENT MONTH
            'NFPBBT_new_acceptor_present_month_10_14' => $NFPBBT_new_acceptor_present_month_10_14,
            'NFPBBT_new_acceptor_present_month_15_19' => $NFPBBT_new_acceptor_present_month_15_19,
            'NFPBBT_new_acceptor_present_month_20_49' => $NFPBBT_new_acceptor_present_month_20_49,
        ];

        return [
            'BTL' => $btl,
            'MSV' => $msv,
            'CONDOM' => $condom,
            'IUD-I' => $iud_i,
            'IUD-PP' => $iud_pp,
            'PILLS-COC' => $pills_coc,
            'PILLS-POP' => $pills_pop,
            'DMPA' => $dmpa,
            'IMPLANT' => $implant,
            'NFP-CMM' => $nfpcm,
            'NFP-BBT' => $nfpbbt,
        ];
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
