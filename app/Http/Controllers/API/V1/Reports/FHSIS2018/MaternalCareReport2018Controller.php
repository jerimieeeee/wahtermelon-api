<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\MaternalCare\MaternalCareReportService;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group FHSIS Reports 2018
 *
 * APIs for managing Maternal Care Report Information
 *
 * @subgroup M1 Maternal Care Report
 *
 * @subgroupDescription M1 FHSIS 2018 Maternal Care Report.
 */
class MaternalCareReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     */
    public function index(Request $request, MaternalCareReportService $maternalCareReportService): array
    {
        //4 PRENATAL GIVE BIRTH AGE 10-14 YEARS
        $prenatal_give_birth_10_14 = $maternalCareReportService->get_4prenatal_give_birth($request, '10', '14')->get();

        //4 PRENATAL GIVE BIRTH AGE 15-19 YEARS
        $prenatal_give_birth_15_19 = $maternalCareReportService->get_4prenatal_give_birth($request, '15', '19')->get();

        //4 PRENATAL GIVE BIRTH AGE 20-49 YEARS
        $prenatal_give_birth_20_49 = $maternalCareReportService->get_4prenatal_give_birth($request, '20', '49')->get();

        //////////////////////
        //PRENATAL ASSESSED NUTRITION AGE 10-14 YEARS
        $prenatal_assessed_10_14 = $maternalCareReportService->pregnant_assessed_nutrition($request, '10', '14')->get();

        //PRENATAL ASSESSED NUTRITION AGE 15-19 YEARS
        $prenatal_assessed_15_19 = $maternalCareReportService->pregnant_assessed_nutrition($request, '15', '19')->get();

        //PRENATAL ASSESSED NUTRITION AGE 20-49 YEARS
        $prenatal_assessed_20_49 = $maternalCareReportService->pregnant_assessed_nutrition($request, '20', '49')->get();

        ///////////////////////
        //PRENATAL NORMAL BMI AGE 10-14 YEARS
        $prenatal_normal_bmi_10_14 = $maternalCareReportService->pregnant_assessed_bmi($request, 'NORMAL', '10', '14')->get();

        //PRENATAL NORMAL BMI AGE 15-19 YEARS
        $prenatal_normal_bmi_15_19 = $maternalCareReportService->pregnant_assessed_bmi($request, 'NORMAL', '15', '19')->get();

        //PRENATAL NORMAL BMI AGE 20-49 YEARS
        $prenatal_normal_bmi__20_49 = $maternalCareReportService->pregnant_assessed_bmi($request, 'NORMAL', '20', '49')->get();

        //////////////////////
        //PRENATAL LOW BMI AGE 10-14 YEARS
        $prenatal_low_bmi_10_14 = $maternalCareReportService->pregnant_assessed_bmi($request, 'LOW', '10', '14')->get();

        //PRENATAL LOW BMI AGE 15-19 YEARS
        $prenatal_low_bmi_15_19 = $maternalCareReportService->pregnant_assessed_bmi($request, 'LOW', '15', '19')->get();

        //PRENATAL LOW BMI AGE 20-49 YEARS
        $prenatal_low_bmi_20_49 = $maternalCareReportService->pregnant_assessed_bmi($request, 'LOW', '20', '49')->get();

        //////////////////////
        //PRENATAL HIGH BMI AGE 10-14 YEARS
        $prenatal_high_bmi_10_14 = $maternalCareReportService->pregnant_assessed_bmi($request, 'HIGH', '10', '14')->get();

        //PRENATAL HIGH BMI AGE 15-19 YEARS
        $prenatal_high_bmi_15_19 = $maternalCareReportService->pregnant_assessed_bmi($request, 'HIGH', '15', '19')->get();

        //PRENATAL HIGH BMI AGE 20-49 YEARS
        $prenatal_high_bmi_20_49 = $maternalCareReportService->pregnant_assessed_bmi($request, 'HIGH', '20', '49')->get();

        /////////////////////
        //PREGNANT WITH 2 TD VACCINE AGE 10-14 YEARS
        $pregnant_2_td_vaccine_10_14 = $maternalCareReportService->pregnant_td2_vaccine($request, '10', '14')->get();

        //PREGNANT WITH 2 TD VACCINE AGE 15-19 YEARS
        $pregnant_2_td_vaccine_15_19 = $maternalCareReportService->pregnant_td2_vaccine($request, '15', '19')->get();

        //PREGNANT WITH 2 TD VACCINE AGE 20-49 YEARS
        $pregnant_2_td_vaccine_20_49 = $maternalCareReportService->pregnant_td2_vaccine($request, '20', '49')->get();

        /////////////////////
        //PREGNANT WITH 3 TD VACCINE AGE 10-14 YEARS
        $pregnant_3_td_vaccine_10_14 = $maternalCareReportService->pregnant_td_vaccine($request, 'TD3', '10', '14')->get();

        //PREGNANT WITH 3 TD VACCINE AGE 15-19 YEARS
        $pregnant_3_td_vaccine_15_19 = $maternalCareReportService->pregnant_td_vaccine($request, 'TD3', '15', '19')->get();

        //PREGNANT WITH 3 TD VACCINE AGE 20-49 YEARS
        $pregnant_3_td_vaccine_20_49 = $maternalCareReportService->pregnant_td_vaccine($request, 'TD3', '20', '49')->get();

        /////////////////////
        //PREGNANT WITH 180 IRON FOLIC ACID AGE 10-14 YEARS

        $pregnant_with_iron_180 = $maternalCareReportService->get_service($request, 'IRON', 'Prenatal');
        $pregnant_with_iron_180 = $pregnant_with_iron_180->get();

        $pregnant_with_180_iron_folic_10_14 = get_completed_services($request, $pregnant_with_iron_180, '180', '10', '14');

        //PREGNANT WITH 180 IRON FOLIC ACID AGE 15-19 YEARS
        $pregnant_with_180_iron_folic_15_19 = get_completed_services($request, $pregnant_with_iron_180, '180', '15', '19');

        //PREGNANT WITH 180 IRON FOLIC ACID AGE 20-49 YEARS
        $pregnant_with_180_iron_folic_20_49 = get_completed_services($request, $pregnant_with_iron_180, '180', '20', '49');

        /////////////////////
        //PREGNANT WITH 420 CALCIUM CARBONATE AGE 10-14 YEARS

        $pregnant_with_420_calcium_carbonate = $maternalCareReportService->get_service($request, 'CALC', 'Prenatal');
        $pregnant_with_420_calcium_carbonate = $pregnant_with_420_calcium_carbonate->get();

        $pregnant_with_420_calcium_carbonate_10_14 = get_completed_services($request, $pregnant_with_420_calcium_carbonate, '420', '10', '14');

        //PREGNANT WITH 420 CALCIUM CARBONATE AGE 15-19 YEARS
        $pregnant_with_420_calcium_carbonate_15_19 = get_completed_services($request, $pregnant_with_420_calcium_carbonate, '420', '15', '19');

        //PREGNANT WITH 420 CALCIUM CARBONATE AGE 20-49 YEARS
        $pregnant_with_420_calcium_carbonate_20_49 = get_completed_services($request, $pregnant_with_420_calcium_carbonate, '420', '20', '49');

        /////////////////////
        //PREGNANT WITH 2 IODINE CAPSULE AGE 10-14 YEARS

        $pregnant_with_2_iodine_capsule = $maternalCareReportService->get_service($request, 'IODN', 'Prenatal');
        $pregnant_with_2_iodine_capsule = $pregnant_with_2_iodine_capsule->get();

        $pregnant_with_2_iodine_capsule_10_14 = get_completed_services($request, $pregnant_with_2_iodine_capsule, '1', '10', '14');

        //PREGNANT WITH 2 IODINE CAPSULE AGE 15-19 YEARS
        $pregnant_with_2_iodine_capsule_15_19 = get_completed_services($request, $pregnant_with_2_iodine_capsule, '1', '15', '19');

        //PREGNANT WITH 2 IODINE CAPSULE AGE 20-49 YEARS
        $pregnant_with_2_iodine_capsule_20_49 = get_completed_services($request, $pregnant_with_2_iodine_capsule, '1', '20', '49');

        /////////////////////
        //PREGNANT WITH 1 DEWORMING TABLET AGE 10-14 YEARS

        $pregnant_with_1_deworming = $maternalCareReportService->get_service($request, 'DWRMG', 'Prenatal');
        $pregnant_with_1_deworming = $pregnant_with_1_deworming->get();

        $pregnant_with_1_deworming_10_14 = get_completed_services($request, $pregnant_with_1_deworming, '1', '10', '14');

        //PREGNANT WITH 1 DEWORMING TABLET AGE 15-19 YEARS
        $pregnant_with_1_deworming_15_19 = get_completed_services($request, $pregnant_with_1_deworming, '1', '10', '14');

        //PREGNANT WITH 1 DEWORMING TABLET AGE 20-49 YEARS
        $pregnant_with_1_deworming_20_49 = get_completed_services($request, $pregnant_with_1_deworming, '1', '10', '14');

        /////////////////////
        //PREGNANT SCREENED SYPHILIS AGE 10-14 YEARS
        $pregnant_screened_syphilis_10_14 = $maternalCareReportService->pregnant_test('N', 'SYP', $request, '10', '14')->get();

        //PREGNANT SCREENED SYPHILIS AGE 15-19 YEARS
        $pregnant_screened_syphilis_15_19 = $maternalCareReportService->pregnant_test('N', 'SYP', $request, '15', '19')->get();

        //PREGNANT SCREENED SYPHILIS AGE 20-49 YEARS
        $pregnant_screened_syphilis_20_49 = $maternalCareReportService->pregnant_test('N', 'SYP', $request, '20', '49')->get();

        /////////////////////
        //PREGNANT SCREENED SYPHILIS POSITIVE AGE 10-14 YEARS
        $pregnant_screened_syphilis_positive_10_14 = $maternalCareReportService->pregnant_test('Y', 'SYP', $request, '10', '14')->get();

        //PREGNANT SCREENED SYPHILIS POSITIVE AGE 15-19 YEARS
        $pregnant_screened_syphilis_positive_15_19 = $maternalCareReportService->pregnant_test('Y', 'SYP', $request, '15', '19')->get();

        //PREGNANT SCREENED SYPHILIS POSITIVE AGE 20-49 YEARS
        $pregnant_screened_syphilis_positive_20_49 = $maternalCareReportService->pregnant_test('Y', 'SYP', $request, '20', '49')->get();

        /////////////////////
        //PREGNANT SCREENED HEPATITIS B AGE 10-14 YEARS
        $pregnant_screened_hepatitis_10_14 = $maternalCareReportService->pregnant_test('N', 'HEPB', $request, '10', '14')->get();

        //PREGNANT SCREENED HEPATITIS B AGE 15-19 YEARS
        $pregnant_screened_hepatitis_15_19 = $maternalCareReportService->pregnant_test('N', 'HEPB', $request, '15', '19')->get();

        //PREGNANT SCREENED HEPATITIS B AGE 20-49 YEARS
        $pregnant_screened_hepatitis_20_49 = $maternalCareReportService->pregnant_test('N', 'HEPB', $request, '20', '49')->get();

        /////////////////////
        //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 10-14 YEARS
        $pregnant_screened_hepatitis_positive_10_14 = $maternalCareReportService->pregnant_test('Y', 'HEPB', $request, '10', '14')->get();

        //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 15-19 YEARS
        $pregnant_screened_hepatitis_positive_15_19 = $maternalCareReportService->pregnant_test('Y', 'HEPB', $request, '15', '19')->get();

        //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 20-49 YEARS
        $pregnant_screened_hepatitis_positive_20_49 = $maternalCareReportService->pregnant_test('Y', 'HEPB', $request, '20', '49')->get();

        /////////////////////
        //PREGNANT SCREENED HIV AGE 10-14 YEARS
        $pregnant_screened_hiv_10_14 = $maternalCareReportService->pregnant_test('N', 'HIV', $request, '10', '14')->get();

        //PREGNANT SCREENED HIV AGE 15-19 YEARS
        $pregnant_screened_hiv_15_19 = $maternalCareReportService->pregnant_test('N', 'HIV', $request, '15', '19')->get();

        //PREGNANT SCREENED HIV AGE 20-49 YEARS
        $pregnant_screened_hiv_20_49 = $maternalCareReportService->pregnant_test('N', 'HIV', $request, '20', '49')->get();

        /////////////////////
        //PREGNANT SCREENED CBC AGE 10-14 YEARS
        $pregnant_screened_cbc_10_14 = $maternalCareReportService->pregnant_test('N', 'CBC', $request, '10', '14')->get();

        //PREGNANT SCREENED CBC AGE 15-19 YEARS
        $pregnant_screened_cbc_15_19 = $maternalCareReportService->pregnant_test('N', 'CBC', $request, '15', '19')->get();

        //PREGNANT SCREENED CBC AGE 20-49 YEARS
        $pregnant_screened_cbc_20_49 = $maternalCareReportService->pregnant_test('N', 'CBC', $request, '20', '49')->get();

        /////////////////////
        //PREGNANT SCREENED CBC POSITIVE AGE 10-14 YEARS
        $pregnant_screened_cbc_positive_10_14 = $maternalCareReportService->pregnant_test('Y', 'CBC', $request, '10', '14')->get();

        //PREGNANT SCREENED CBC POSITIVE AGE 15-19 YEARS
        $pregnant_screened_cbc_positive_15_19 = $maternalCareReportService->pregnant_test('Y', 'CBC', $request, '15', '19')->get();

        //PREGNANT SCREENED CBC POSITIVE AGE 20-49 YEARS
        $pregnant_screened_cbc_positive_20_49 = $maternalCareReportService->pregnant_test('Y', 'CBC', $request, '20', '49')->get();

        /////////////////////
        //PREGNANT SCREENED GASTRO DIABETES AGE 10-14 YEARS
        $pregnant_screened_gastro_diabetes_10_14 = $maternalCareReportService->pregnant_test('N', 'DIBTS', $request, '10', '14')->get();

        //PREGNANT SCREENED GASTRO DIABETES AGE 15-19 YEARS
        $pregnant_screened_gastro_diabetes_15_19 = $maternalCareReportService->pregnant_test('N', 'DIBTS', $request, '15', '19')->get();

        //PREGNANT SCREENED GASTRO DIABETES AGE 20-49 YEARS
        $pregnant_screened_gastro_diabetes_20_49 = $maternalCareReportService->pregnant_test('N', 'DIBTS', $request, '20', '49')->get();

        /////////////////////
        //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 10-14 YEARS
        $pregnant_screened_gastro_diabetes_positive_10_14 = $maternalCareReportService->pregnant_test('Y', 'DIBTS', $request, '10', '14')->get();

        //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 15-19 YEARS
        $pregnant_screened_gastro_diabetes_positive_15_19 = $maternalCareReportService->pregnant_test('Y', 'DIBTS', $request, '15', '19')->get();

        //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 20-49 YEARS
        $pregnant_screened_gastro_diabetes_positive_20_49 = $maternalCareReportService->pregnant_test('Y', 'DIBTS', $request, '20', '49')->get();

        /////////////////////
        //NO. OF POSTPARTUM WITH 2 POSTPARTUM CHECKUP AGE 10-14 YEARS
        $no_of_postpartum_with_2_checkup_10_14 = $maternalCareReportService->post_partum_2_checkup($request, '10', '14')->get();

        //NO. OF DELIVERIES AGE 15-19 YEARS
        $no_of_postpartum_with_2_checkup_15_19 = $maternalCareReportService->post_partum_2_checkup($request, '15', '19')->get();

        //NO. OF DELIVERIES AGE 20-49 YEARS
        $no_of_postpartum_with_2_checkup_20_49 = $maternalCareReportService->post_partum_2_checkup($request, '20', '49')->get();

        /////////////////////
        //NO. OF POSTPARTUM WOMEN WITH IRON

        $no_of_postpartum_women_with_iron = $maternalCareReportService->get_service($request, 'IRON', 'Postpartum');
        $no_of_postpartum_women_with_iron = $no_of_postpartum_women_with_iron->get();

        //POSTPARTUM WITH 90 IRON AGE 10-14 YEARS
        $no_of_postpartum_women_with_iron_10_14 = get_completed_services($request, $no_of_postpartum_women_with_iron, '90', '10', '14');

        //POSTPARTUM WITH 90 IRON AGE 15-19 YEARS
        $no_of_postpartum_women_with_iron_15_19 = get_completed_services($request, $no_of_postpartum_women_with_iron, '90', '15', '19');

        //POSTPARTUM WOMEN WITH 90 IRON AGE 20-49 YEARS
        $no_of_postpartum_women_with_iron_20_49 = get_completed_services($request, $no_of_postpartum_women_with_iron, '90', '20', '49');

        /////////////////////
        //NO. OF POSTPARTUM WOMEN WITH VITAMIN A

        $no_of_postpartum_women_with_vita = $maternalCareReportService->get_service($request, 'VITA', 'Postpartum');
        $no_of_postpartum_women_with_vita = $no_of_postpartum_women_with_vita->get();

        //POSTPARTUM WOMEN WITH 1 VITA AGE 10-14 YEARS
        $no_of_postpartum_women_with_vita_10_14 = get_completed_services($request, $no_of_postpartum_women_with_vita, '1', '10', '14');

        //POSTPARTUM WOMEN WITH 1 VITA AGE 15-19 YEARS
        $no_of_postpartum_women_with_vita_15_19 = get_completed_services($request, $no_of_postpartum_women_with_vita, '1', '15', '19');

        //POSTPARTUM WOMEN WITH 1 VITA AGE 20-49 YEARS
        $no_of_postpartum_women_with_vita_20_49 = get_completed_services($request, $no_of_postpartum_women_with_vita, '1', '20', '49');

        /////////////////////
        //NO. OF DELIVERIES AGE 10-14 YEARS
        $no_of_deliveries_10_14 = $maternalCareReportService->get_no_of_deliveries($request, '10', '14')->get();

        //NO. OF DELIVERIES AGE 15-19 YEARS
        $no_of_deliveries_15_19 = $maternalCareReportService->get_no_of_deliveries($request, '15', '19')->get();

        //NO. OF DELIVERIES AGE 20-49 YEARS
        $no_of_deliveries_20_49 = $maternalCareReportService->get_no_of_deliveries($request, '20', '49')->get();

        /////////////////////
        //NO. OF LIVEBIRTHS ALL
        $no_of_livebirths_all = $maternalCareReportService->get_no_of_livebirths($request, 'ALL')->get();

        //NO. OF LIVEBIRTHS MALE
        $no_of_livebirths_male = $maternalCareReportService->get_no_of_livebirths($request, 'MALE')->get();

        //NO. OF LIVEBIRTHS FEMALE
        $no_of_livebirths_female = $maternalCareReportService->get_no_of_livebirths($request, 'FEMALE')->get();

        /////////////////////
        //NO. OF LIVEBIRTHS BY BIRTH WEIGHT NORMAL
        $no_of_livebirths_by_weight_normal = $maternalCareReportService->get_no_of_livebirths_by_weight($request, 'NORMAL')->get();

        //NO. OF LIVEBIRTHS BY BIRTH WEIGHT LOW
        $no_of_livebirths_by_weight_low = $maternalCareReportService->get_no_of_livebirths_by_weight($request, 'LOW')->get();

        //NO. OF LIVEBIRTHS BY BIRTH WEIGHT UNKNOWN
        $no_of_livebirths_by_weight_unknown = $maternalCareReportService->get_no_of_livebirths_by_weight($request, 'UNKNOWN')->get();

        /////////////////////
        //NO. OF DELIVERIES ATTENDED ALL
        $no_of_deliveries_attended_all = $maternalCareReportService->get_no_of_deliveries_professional($request, 'ALL')->get();

        //NO. OF DELIVERIES ATTENDED BY DOCTOR
        $no_of_deliveries_attended_by_doctor = $maternalCareReportService->get_no_of_deliveries_professional($request, 'DOCTOR')->get();

        //NO. OF DELIVERIES ATTENDED BY NURSE
        $no_of_deliveries_attended_by_nurse = $maternalCareReportService->get_no_of_deliveries_professional($request, 'NURSE')->get();

        //NO. OF DELIVERIES ATTENDED BY MIDWIFE
        $no_of_deliveries_attended_by_midwife = $maternalCareReportService->get_no_of_deliveries_professional($request, 'MIDWIFE')->get();

        /////////////////////
        //NO. OF DELIVERIES HEALTH FACILITY BASED
        $no_of_deliveries_health_facility_all = $maternalCareReportService->get_no_of_deliveries_health_facility($request, 'ALL')->get();

        //NO. OF DELIVERIES ATTENDED BY DOCTOR
        $no_of_deliveries_health_facility_public = $maternalCareReportService->get_no_of_deliveries_health_facility($request, 'PUBLIC-HF')->get();

        //NO. OF DELIVERIES ATTENDED BY NURSE
        $no_of_deliveries_health_facility_private = $maternalCareReportService->get_no_of_deliveries_health_facility($request, 'PRIVATE-HF')->get();

        //NO. OF DELIVERIES ATTENDED BY MIDWIFE
        $no_of_deliveries_health_facility_non = $maternalCareReportService->get_no_of_deliveries_health_facility($request, 'NON-HF')->get();

        /////////////////////
        //NO. OF DELIVERIES TYPE OF DELIVERY ALL
        $no_of_deliveries_type_of_delivery_all = $maternalCareReportService->get_no_of_type_of_delivery_all($request, 'ALL', '', '')->get();

        //NO. OF DELIVERIES TYPE OF DELIVERY NSD AGE 10-14 YEARS
        $no_of_deliveries_type_of_delivery_nsd_10_14 = $maternalCareReportService->get_no_of_type_of_delivery_nsd_cs($request, 'NSD', '10', '14')->get();

        //NO. OF DELIVERIES TYPE OF DELIVERY NSD AGE 15-19 YEARS
        $no_of_deliveries_type_of_delivery_nsd_15_19 = $maternalCareReportService->get_no_of_type_of_delivery_nsd_cs($request, 'NSD', '15', '19')->get();

        //NO. OF DELIVERIES TYPE OF DELIVERY NSD AGE 20-49 YEARS
        $no_of_deliveries_type_of_delivery_nsd_20_49 = $maternalCareReportService->get_no_of_type_of_delivery_nsd_cs($request, 'NSD', '20', '49')->get();

        //NO. OF DELIVERIES TYPE OF DELIVERY CS AGE 10-14 YEARS
        $no_of_deliveries_type_of_delivery_cs_10_14 = $maternalCareReportService->get_no_of_type_of_delivery_nsd_cs($request, 'CS', '10', '14')->get();

        //NO. OF DELIVERIES TYPE OF DELIVERY CS AGE 15-19 YEARS
        $no_of_deliveries_type_of_delivery_cs_15_19 = $maternalCareReportService->get_no_of_type_of_delivery_nsd_cs($request, 'CS', '15', '19')->get();

        //NO. OF DELIVERIES TYPE OF DELIVERY CS AGE 20-49 YEARS
        $no_of_deliveries_type_of_delivery_cs_20_49 = $maternalCareReportService->get_no_of_type_of_delivery_nsd_cs($request, 'CS', '20', '49')->get();

        /////////////////////
        //NO. OF PREGNANCY OUTCOME ALL
        $no_of_pregnancy_outcome_all = $maternalCareReportService->get_no_of_pregnancy_outcome_all($request)->get();

        /////////////////////
        //NO. OF PREGNANCY OUTCOME FULLTERM AGE 10-14 YEARS
        $no_of_pregnancy_outcome_fullterm_10_14 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'FULL-TERM', '10', '14')->get();

        //NO. OF PREGNANCY OUTCOME FULLTERM AGE 15-19 YEAR
        $no_of_pregnancy_outcome_fullterm_15_19 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'FULL-TERM', '15', '19')->get();

        //NO. OF PREGNANCY OUTCOME FULLTERM AGE 20-49 YEAR
        $no_of_pregnancy_outcome_fullterm_20_49 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'FULL-TERM', '20', '49')->get();

        /////////////////////
        //NO. OF DELIVERIES TYPE OF DELIVERY PRETERM
        //NO. OF PREGNANCY OUTCOME PRETERM AGE 10-14 YEARS
        $no_of_pregnancy_outcome_preterm_10_14 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'PRE-TERM', '10', '14')->get();

        //NO. OF PREGNANCY OUTCOME PRETERM AGE 15-19 YEAR
        $no_of_pregnancy_outcome_preterm_15_19 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'PRE-TERM', '15', '19')->get();

        //NO. OF PREGNANCY OUTCOME PRETERM AGE 20-49 YEAR
        $no_of_pregnancy_outcome_preterm_20_49 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'PRE-TERM', '20', '49')->get();

        /////////////////////
        //NO. OF DELIVERIES TYPE OF DELIVERY PRETERM
        //NO. OF PREGNANCY OUTCOME PRETERM AGE 10-14 YEARS
        $no_of_pregnancy_outcome_preterm_10_14 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'PRE-TERM', '10', '14')->get();

        //NO. OF PREGNANCY OUTCOME PRETERM AGE 15-19 YEAR
        $no_of_pregnancy_outcome_preterm_15_19 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'PRE-TERM', '15', '19')->get();

        //NO. OF PREGNANCY OUTCOME PRETERM AGE 20-49 YEAR
        $no_of_pregnancy_outcome_preterm_20_49 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'PRE-TERM', '20', '49')->get();

        /////////////////////
        //NO. OF DELIVERIES TYPE OF DELIVERY FETAL DEATH
        //NO. OF PREGNANCY OUTCOME FETAL DEATH AGE 10-14 YEARS
        $no_of_pregnancy_outcome_fetal_death_10_14 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'FETAL-DEATH', '10', '14')->get();

        //NO. OF PREGNANCY OUTCOME FETAL DEATH AGE 15-19 YEAR
        $no_of_pregnancy_outcome_fetal_death_15_19 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'FETAL-DEATH', '15', '19')->get();

        //NO. OF PREGNANCY OUTCOME FETAL DEATH AGE 20-49 YEAR
        $no_of_pregnancy_outcome_fetal_death_20_49 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'FETAL-DEATH', '20', '49')->get();

        /////////////////////
        //NO. OF DELIVERIES TYPE OF DELIVERY ABORTION
        //NO. OF PREGNANCY OUTCOME ABORTION AGE 10-14 YEARS
        $no_of_pregnancy_outcome_abortion_10_14 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'ABORTION', '10', '14')->get();

        //NO. OF PREGNANCY OUTCOME ABORTION AGE 15-19 YEAR
        $no_of_pregnancy_outcome_abortion_15_19 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'ABORTION', '15', '19')->get();

        //NO. OF PREGNANCY OUTCOME ABORTION AGE 20-49 YEAR
        $no_of_pregnancy_outcome_abortion_20_49 = $maternalCareReportService->get_no_of_pregnancy_outcome($request, 'ABORTION', '20', '49')->get();

        return [

            //4 PRENATAL GIVE BIRTH AGE 10-14 YEARS
            'Prenatal_give_birth_10_14' => $prenatal_give_birth_10_14,

            //4 PRENATAL GIVE BIRTH AGE 15-19 YEARS
            'Prenatal_give_birth_15_19' => $prenatal_give_birth_15_19,

            //4 PRENATAL GIVE BIRTH AGE 20-49 YEARS
            'Prenatal_give_birth_20_49' => $prenatal_give_birth_20_49,

            ///////////////////////
            //PRENATAL ASSESSED NUTRITION AGE 10-14 YEARS
            'prenatal_assessed_10_14' => $prenatal_assessed_10_14,

            //PRENATAL ASSESSED NUTRITION AGE 15-19 YEARS
            'prenatal_assessed_15_19' => $prenatal_assessed_15_19,

            //PRENATAL ASSESSED NUTRITION AGE 20-49 YEARS
            'prenatal_assessed_20_49' => $prenatal_assessed_20_49,

            ///////////////////////
            //PRENATAL HIGH BMI AGE 10-14 YEARS
            'prenatal_high_bmi_10_14' => $prenatal_high_bmi_10_14,

            //PRENATAL HIGH BMI AGE 15-19 YEARS
            'prenatal_high_bmi_15_19' => $prenatal_high_bmi_15_19,

            //PRENATAL HIGH BMI AGE 20-49 YEARS
            'prenatal_high_bmi_20_49' => $prenatal_high_bmi_20_49,

            ///////////////////////
            //PRENATAL NORMAL BMI AGE 10-14 YEARS
            'prenatal_normal_bmi_10_14' => $prenatal_normal_bmi_10_14,

            //PRENATAL NORMAL BMI AGE 15-19 YEARS
            'prenatal_normal_bmi_15_19' => $prenatal_normal_bmi_15_19,

            //PRENATAL NORMAL BMI AGE 20-49 YEARS
            'prenatal_normal_bmi_20_49' => $prenatal_normal_bmi__20_49,

            ///////////////////////
            //PRENATAL LOW BMI AGE 10-14 YEARS
            'prenatal_low_bmi_10_14' => $prenatal_low_bmi_10_14,

            //PRENATAL LOW BMI AGE 15-19 YEARS
            'prenatal_low_bmi_15_19' => $prenatal_low_bmi_15_19,

            //PRENATAL LOW BMI AGE 20-49 YEARS
            'prenatal_low_bmi_20_49' => $prenatal_low_bmi_20_49,

            ///////////////////////
            //PREGNANT WITH 2 TD VACCINE AGE 10-14 YEARS
            'pregnant_2_TD_vaccine_10_14' => $pregnant_2_td_vaccine_10_14,

            //PREGNANT WITH 2 TD VACCINE AGE 15-19 YEARS
            'pregnant_2_TD_vaccine_15_19' => $pregnant_2_td_vaccine_15_19,

            //PREGNANT WITH 2 TD VACCINE AGE 20-49 YEARS
            'pregnant_2_TD_vaccine_20_49' => $pregnant_2_td_vaccine_20_49,

            ///////////////////////
            //PREGNANT WITH 3 TD VACCINE AGE 10-14 YEARS
            'pregnant_3_TD_vaccine_10_14' => $pregnant_3_td_vaccine_10_14,

            //PREGNANT WITH 3 TD VACCINE AGE 15-19 YEARS
            'pregnant_3_TD_vaccine_15_19' => $pregnant_3_td_vaccine_15_19,

            //PREGNANT WITH 3 TD VACCINE AGE 20-49 YEARS
            'pregnant_3_TD_vaccine_20_49' => $pregnant_3_td_vaccine_20_49,

            ///////////////////////
            //PREGNANT WITH 180 IRON FOLIC ACID AGE 10-14 YEARS
            'pregnant_with_180_iron_folic_10_14' => $pregnant_with_180_iron_folic_10_14,

            //PREGNANT WITH 180 IRON FOLIC ACID AGE 15-19 YEARS
            'pregnant_with_180_iron_folic_15_19' => $pregnant_with_180_iron_folic_15_19,

            //PREGNANT WITH 180 IRON FOLIC ACID AGE 20-49 YEARS
            'pregnant_with_180_iron_folic_20_49' => $pregnant_with_180_iron_folic_20_49,

            /////////////////////
            //PREGNANT WITH 420 CALCIUM CARBONATE AGE 10-14 YEARS
            'pregnant_with_420_calcium_carbonate_10_14' => $pregnant_with_420_calcium_carbonate_10_14,

            //PREGNANT WITH 420 CALCIUM CARBONATE AGE 15-19 YEARS
            'pregnant_with_420_calcium_carbonate_15_19' => $pregnant_with_420_calcium_carbonate_15_19,

            //PREGNANT WITH 420 CALCIUM CARBONATE AGE 20-49 YEARS
            'pregnant_with_420_calcium_carbonate_20_49' => $pregnant_with_420_calcium_carbonate_20_49,

            ///////////////////////
            //PREGNANT WITH 2 IODINE CAPSULE AGE 10-14 YEARS
            'pregnant_with_2_iodine_capsule_10_14' => $pregnant_with_2_iodine_capsule_10_14,

            //PREGNANT WITH 2 IODINE CAPSULE AGE 15-19 YEARS
            'pregnant_with_2_iodine_capsule_15_19' => $pregnant_with_2_iodine_capsule_15_19,

            //PREGNANT WITH 2 IODINE CAPSULE AGE 20-49 YEARSS
            'pregnant_with_2_iodine_capsule_20_49' => $pregnant_with_2_iodine_capsule_20_49,

            ///////////////////////
            //PREGNANT WITH 1 DEWORMING TABLET AGE 10-14 YEARS
            'pregnant_with_1_deworming_10_14' => $pregnant_with_1_deworming_10_14,

            //PREGNANT WITH 1 DEWORMING TABLET AGE 15-19 YEARS
            'pregnant_with_1_deworming_15_19' => $pregnant_with_1_deworming_15_19,

            //PREGNANT WITH 1 DEWORMING TABLET AGE 20-49 YEARS
            'pregnant_with_1_deworming_20_49' => $pregnant_with_1_deworming_20_49,

            ///////////////////////
            //PREGNANT SCREENED SYPHILIS AGE 10-14 YEARS
            'pregnant_screened_syphilis_10_14' => $pregnant_screened_syphilis_10_14,

            //PREGNANT SCREENED SYPHILIS AGE 15-19 YEARS
            'pregnant_screened_syphilis_15_19' => $pregnant_screened_syphilis_15_19,

            //PREGNANT SCREENED SYPHILIS AGE 20-49 YEARS
            'pregnant_screened_syphilis_20_49' => $pregnant_screened_syphilis_20_49,

            ///////////////////////
            //PREGNANT SCREENED SYPHILIS POSITIVE AGE 10-14 YEARS
            'pregnant_screened_syphilis_positive_10_14' => $pregnant_screened_syphilis_positive_10_14,

            //PREGNANT SCREENED SYPHILIS POSITIVE AGE 15-19 YEARS
            'pregnant_screened_syphilis_positive_15_19' => $pregnant_screened_syphilis_positive_15_19,

            //PREGNANT SCREENED SYPHILIS POSITIVE AGE 20-49 YEARS
            'pregnant_screened_syphilis_positive_20_49' => $pregnant_screened_syphilis_positive_20_49,

            ///////////////////////
            //PREGNANT SCREENED HEPATITIS B AGE 10-14 YEARS
            'pregnant_screened_hepatitis_10_14' => $pregnant_screened_hepatitis_10_14,

            //PREGNANT SCREENED HEPATITIS B AGE 15-19 YEARS
            'pregnant_screened_hepatitis_15_19' => $pregnant_screened_hepatitis_15_19,

            //PREGNANT SCREENED HEPATITIS B AGE 20-49 YEARS
            'pregnant_screened_hepatitis_20_49' => $pregnant_screened_hepatitis_20_49,

            ///////////////////////
            //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 10-14 YEARS
            'pregnant_screened_hepatitis_positive_10_14' => $pregnant_screened_hepatitis_positive_10_14,

            //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 15-19 YEARS
            'pregnant_screened_hepatitis_positive_15_19' => $pregnant_screened_hepatitis_positive_15_19,

            //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 20-49 YEARS
            'pregnant_screened_hepatitis_positive_20_49' => $pregnant_screened_hepatitis_positive_20_49,

            ///////////////////////
            //PREGNANT SCREENED HIV AGE 10-14 YEARS
            'pregnant_screened_hiv_10_14' => $pregnant_screened_hiv_10_14,

            //PREGNANT SCREENED HIV AGE 15-19 YEARS
            'pregnant_screened_hiv_15_19' => $pregnant_screened_hiv_15_19,

            //PREGNANT SCREENED HIV AGE 20-49 YEARS
            'pregnant_screened_hiv_20_49' => $pregnant_screened_hiv_20_49,

            ///////////////////////
            //PREGNANT SCREENED CBC AGE 10-14 YEARS
            'pregnant_screened_cbc_10_14' => $pregnant_screened_cbc_10_14,

            //PREGNANT SCREENED CBC AGE 15-19 YEARS
            'pregnant_screened_cbc_15_19' => $pregnant_screened_cbc_15_19,

            //PREGNANT SCREENED CBC AGE 20-49 YEARS
            'pregnant_screened_cbc_20_49' => $pregnant_screened_cbc_20_49,

            ///////////////////////
            //PREGNANT SCREENED CBC POSITIVE AGE 10-14 YEARS
            'pregnant_screened_cbc_positive_10_14' => $pregnant_screened_cbc_positive_10_14,

            //PREGNANT SCREENED CBC POSITIVE AGE 15-19 YEARS
            'pregnant_screened_cbc_positive_15_19' => $pregnant_screened_cbc_positive_15_19,

            //PREGNANT SCREENED CBC POSITIVE AGE 20-49 YEARS
            'pregnant_screened_cbc_positive_20_49' => $pregnant_screened_cbc_positive_20_49,

            ///////////////////////
            //PREGNANT SCREENED GASTRO DIABETES AGE 10-14 YEARS
            'pregnant_screened_gastro_diabetes_10_14' => $pregnant_screened_gastro_diabetes_10_14,

            //PREGNANT SCREENED GASTRO DIABETES AGE 15-19 YEARS
            'pregnant_screened_gastro_diabetes_15_19' => $pregnant_screened_gastro_diabetes_15_19,

            //PREGNANT SCREENED GASTRO DIABETES AGE 20-49 YEARS
            'pregnant_screened_gastro_diabetes_20_49' => $pregnant_screened_gastro_diabetes_20_49,

            ///////////////////////
            //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 10-14 YEARS
            'pregnant_screened_gastro_diabetes_positive_10_14' => $pregnant_screened_gastro_diabetes_positive_10_14,

            //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 15-19 YEARS
            'pregnant_screened_gastro_diabetes_positive_15_19' => $pregnant_screened_gastro_diabetes_positive_15_19,

            //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 20-49 YEARS
            'pregnant_screened_gastro_diabetes_positive_20_49' => $pregnant_screened_gastro_diabetes_positive_20_49,

            ///////////////////////
            //NO. OF POSTPARTUM WOMEN WITH 2 POSTPARTUM CHECKUP AGE 10-14 YEARS
            'no_of_postpartum_women_with_2_checkup_10_14' => $no_of_postpartum_with_2_checkup_10_14,

            //NO. OF POSTPARTUM WOMEN WITH 2 POSTPARTUM CHECKUP AGE 15-19 YEARS
            'no_of_postpartum_women_with_2_checkup_15_19' => $no_of_postpartum_with_2_checkup_15_19,

            //NO. OF POSTPARTUM WOMEN WITH 2 POSTPARTUM CHECKUP AGE 20-49 YEARS
            'no_of_postpartum_women_with_2_checkup_20_49' => $no_of_postpartum_with_2_checkup_20_49,

            /////////////////////
            //NO. OF POSTPARTUM WOMEN WITH 90 IRON AGE 10-14 YEARS
            'no_of_postpartum_women_with_iron_10_14' => $no_of_postpartum_women_with_iron_10_14,

            //NO. OF POSTPARTUM WOMEN WITH 90 IRON AGE 15-19 YEARS
            'no_of_postpartum_women_with_iron_15_19' => $no_of_postpartum_women_with_iron_15_19,

            //NO. OF POSTPARTUM WOMEN WITH 90 IRON AGE 20-49 YEARS
            'no_of_postpartum_women_with_iron_20_49' => $no_of_postpartum_women_with_iron_20_49,

            /////////////////////
            //NO. OF POSTPARTUM WOMEN WITH VIT A AGE 10-14 YEARS
            'no_of_postpartum_women_with_vita_10_14' => $no_of_postpartum_women_with_vita_10_14,

            //NO. OF POSTPARTUM WOMEN WITH VIT A  AGE 15-19 YEARS
            'no_of_postpartum_women_with_vita_15_19' => $no_of_postpartum_women_with_vita_15_19,

            //NO. OF POSTPARTUM WOMEN WITH VIT A  AGE 20-49 YEARS
            'no_of_postpartum_women_with_vita_20_49' => $no_of_postpartum_women_with_vita_20_49,

            /////////////////////
            //NO. OF DELIVERIES AGE 10-14 YEARS
            'no_of_deliveries_10_14' => $no_of_deliveries_10_14,

            //NO. OF DELIVERIES AGE 15-19 YEARS
            'no_of_deliveries_15_19' => $no_of_deliveries_15_19,

            //NO. OF DELIVERIES AGE 20-49 YEARS
            'no_of_deliveries_20_49' => $no_of_deliveries_20_49,

            /////////////////////
            //NO. OF LIVEBIRTHS ALL
            'no_of_livebirths_all' => $no_of_livebirths_all,

            //NO. OF LIVEBIRTHS MALE
            'no_of_livebirths_male' => $no_of_livebirths_male,

            //NO. OF LIVEBIRTHS FEMALE
            'no_of_livebirths_female' => $no_of_livebirths_female,

            /////////////////////
            //NO. OF LIVEBIRTHS BY BIRTH WEIGHT NORMAL
            'no_of_livebirths_by_weight_normal' => $no_of_livebirths_by_weight_normal,

            //NO. OF LIVEBIRTHS BY BIRTH WEIGHT LOW
            'no_of_livebirths_by_weight_low' => $no_of_livebirths_by_weight_low,

            //NO. OF LIVEBIRTHS BY BIRTH WEIGHT UNKNOWN
            'no_of_livebirths_by_weight_unknown' => $no_of_livebirths_by_weight_unknown,

            /////////////////////
            //NO. OF DELIVERIES ATTENDED ALL
            'no_of_deliveries_attended_all' => $no_of_deliveries_attended_all,

            //NO. OF DELIVERIES ATTENDED BY DOCTOR
            'no_of_deliveries_attended_by_doctor' => $no_of_deliveries_attended_by_doctor,

            //NO. OF DELIVERIES ATTENDED BY NURSE
            'no_of_deliveries_attended_by_nurse' => $no_of_deliveries_attended_by_nurse,

            //NO. OF DELIVERIES ATTENDED BY MIDWIFE
            'no_of_deliveries_attended_by_midwife' => $no_of_deliveries_attended_by_midwife,

            /////////////////////
            //NO. OF DELIVERIES HEALTH FACILITY BASED ALL
            'no_of_deliveries_health_facility_all' => $no_of_deliveries_health_facility_all,

            //NO. OF DELIVERIES HEALTH FACILITY BASED PUBLIC-HF
            'no_of_deliveries_health_facility_public' => $no_of_deliveries_health_facility_public,

            //NO. OF DELIVERIES HEALTH FACILITY BASED PRIVATE-HF
            'no_of_deliveries_health_facility_private' => $no_of_deliveries_health_facility_private,

            //NO. OF DELIVERIES HEALTH FACILITY BASED NON-HF
            'no_of_deliveries_health_facility_non' => $no_of_deliveries_health_facility_non,

            /////////////////////
            //NO. OF DELIVERIES TYPE OF DELIVERY ALL
            'no_of_deliveries_type_of_delivery_all' => $no_of_deliveries_type_of_delivery_all,

            //NO. OF DELIVERIES TYPE OF DELIVERY NSD AGE 10-14 YEARS
            'no_of_deliveries_type_of_delivery_nsd_10_14' => $no_of_deliveries_type_of_delivery_nsd_10_14,

            //NO. OF DELIVERIES TYPE OF DELIVERY NSD AGE 15-19 YEARS
            'no_of_deliveries_type_of_delivery_nsd_15_19' => $no_of_deliveries_type_of_delivery_nsd_15_19,

            //NO. OF DELIVERIES TYPE OF DELIVERY NSD AGE 20-49 YEARS
            'no_of_deliveries_type_of_delivery_nsd_20_49' => $no_of_deliveries_type_of_delivery_nsd_20_49,

            //NO. OF DELIVERIES TYPE OF DELIVERY CS AGE 10-14 YEARS
            'no_of_deliveries_type_of_delivery_cs_10_14' => $no_of_deliveries_type_of_delivery_cs_10_14,

            //NO. OF DELIVERIES TYPE OF DELIVERY CS AGE 15-19 YEARS
            'no_of_deliveries_type_of_delivery_cs_15_19' => $no_of_deliveries_type_of_delivery_cs_15_19,

            //NO. OF DELIVERIES TYPE OF DELIVERY CS AGE 20-49 YEARS
            'no_of_deliveries_type_of_delivery_cs_20_49' => $no_of_deliveries_type_of_delivery_cs_20_49,

            /////////////////////
            //NO. OF PREGNANCY OUTCOME ALL
            'no_of_pregnancy_outcome_all' => $no_of_pregnancy_outcome_all,

            /////////////////////
            //NO. OF PREGNANCY OUTCOME FULLTERM AGE 10-14 YEARS
            'no_of_pregnancy_outcome_fullterm_10_14' => $no_of_pregnancy_outcome_fullterm_10_14,

            //NO. OF PREGNANCY OUTCOME FULLTERM AGE 15-19 YEAR
            'no_of_pregnancy_outcome_fullterm_15_19' => $no_of_pregnancy_outcome_fullterm_15_19,
            //NO. OF PREGNANCY OUTCOME FULLTERM AGE 20-49 YEAR
            'no_of_pregnancy_outcome_fullterm_20_49' => $no_of_pregnancy_outcome_fullterm_20_49,

            /////////////////////
            //NO. OF DELIVERIES TYPE OF DELIVERY PRETERM
            //NO. OF PREGNANCY OUTCOME PRETERM AGE 10-14 YEARS
            'no_of_pregnancy_outcome_preterm_10_14' => $no_of_pregnancy_outcome_preterm_10_14,

            //NO. OF PREGNANCY OUTCOME PRETERM AGE 15-19 YEAR
            'no_of_pregnancy_outcome_preterm_15_19' => $no_of_pregnancy_outcome_preterm_15_19,

            //NO. OF PREGNANCY OUTCOME PRETERM AGE 20-49 YEAR
            'no_of_pregnancy_outcome_preterm_20_49' => $no_of_pregnancy_outcome_preterm_20_49,

            /////////////////////
            //NO. OF DELIVERIES TYPE OF DELIVERY FETAL DEATH
            //NO. OF PREGNANCY OUTCOME FETAL DEATH AGE 10-14 YEARS
            'no_of_pregnancy_outcome_fetal_death_10_14' => $no_of_pregnancy_outcome_fetal_death_10_14,

            //NO. OF PREGNANCY OUTCOME FETAL DEATH AGE 15-19 YEAR
            'no_of_pregnancy_outcome_fetal_death_15_19' => $no_of_pregnancy_outcome_fetal_death_15_19,

            //NO. OF PREGNANCY OUTCOME FETAL DEATH AGE 20-49 YEAR
            'no_of_pregnancy_outcome_fetal_death_20_49' => $no_of_pregnancy_outcome_fetal_death_20_49,

            /////////////////////
            //NO. OF DELIVERIES TYPE OF DELIVERY ABORTION
            //NO. OF PREGNANCY OUTCOME ABORTION AGE 10-14 YEARS
            'no_of_pregnancy_outcome_abortion_10_14' => $no_of_pregnancy_outcome_abortion_10_14,

            //NO. OF PREGNANCY OUTCOME ABORTION AGE 15-19 YEAR
            'no_of_pregnancy_outcome_abortion_15_19' => $no_of_pregnancy_outcome_abortion_15_19,

            //NO. OF PREGNANCY OUTCOME ABORTION AGE 20-49 YEAR
            'no_of_pregnancy_outcome_abortion_20_49' => $no_of_pregnancy_outcome_abortion_20_49,

        ];
    }

    /**
     * Store a newly created resource in storage.
     *
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
