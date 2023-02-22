<?php

namespace App\Http\Controllers\API\V1\Reports;

use App\Http\Controllers\Controller;
use App\Services\MaternalCare\MaternalCareReportService;
use Illuminate\Http\Request;

/**
 * @authenticated
 * @group Reports 2018
 *
 * APIs for managing Maternal Care Report Information
 * @subgroup M1 Maternal Care Report
 * @subgroupDescription M1 FHSIS 2018 Maternal Care Report.
 */
class MaternalCareReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     * @param Request $request
     * @param MaternalCareReportService $maternalCareReportService
     */
    public function index(Request $request, MaternalCareReportService $maternalCareReportService): array
    {
        //4 PRENATAL GIVE BIRTH AGE 10-14 YEARS
        $prenatal_give_birth_10_14 =  $maternalCareReportService->get_4prenatal_give_birth($request, '10', '14')->get();

        //4 PRENATAL GIVE BIRTH AGE 15-19 YEARS
        $prenatal_give_birth_15_19 =  $maternalCareReportService->get_4prenatal_give_birth($request, '15', '19')->get();

        //4 PRENATAL GIVE BIRTH AGE 20-49 YEARS
        $prenatal_give_birth_20_49 =  $maternalCareReportService->get_4prenatal_give_birth($request, '20', '49')->get();

        //////////////////////
        //PRENATAL ASSESSED NUTRITION AGE 10-14 YEARS
        $prenatal_assessed_10_14 =  $maternalCareReportService->pregnant_assessed_nutrition($request, '10', '14')->get();

        //PRENATAL ASSESSED NUTRITION AGE 15-19 YEARS
        $prenatal_assessed_15_19 =  $maternalCareReportService->pregnant_assessed_nutrition($request, '15', '19')->get();

        //PRENATAL ASSESSED NUTRITION AGE 20-49 YEARS
        $prenatal_assessed_20_49 =  $maternalCareReportService->pregnant_assessed_nutrition($request, '20', '49')->get();

        ///////////////////////
        //PRENATAL NORMAL BMI AGE 10-14 YEARS
        $prenatal_normal_bmi_10_14 =  $maternalCareReportService->pregnant_normal_bmi($request, 'NORMAL', '10', '14')->get();

        //PRENATAL NORMAL BMI AGE 15-19 YEARS
        $prenatal_normal_bmi_15_19 =  $maternalCareReportService->pregnant_normal_bmi($request, 'NORMAL', '15', '19')->get();

        //PRENATAL NORMAL BMI AGE 20-49 YEARS
        $prenatal_normal_bmi__20_49 =  $maternalCareReportService->pregnant_normal_bmi($request, 'NORMAL', '20', '49')->get();


        //////////////////////
        //PRENATAL LOW BMI AGE 10-14 YEARS
        $prenatal_low_bmi_10_14 =  $maternalCareReportService->pregnant_low_bmi($request, 'LOW', '10', '14')->get();

        //PRENATAL LOW BMI AGE 15-19 YEARS
        $prenatal_low_bmi_15_19 =  $maternalCareReportService->pregnant_low_bmi($request, 'LOW', '15', '19')->get();

        //PRENATAL LOW BMI AGE 20-49 YEARS
        $prenatal_low_bmi_20_49 =  $maternalCareReportService->pregnant_low_bmi($request, 'LOW', '20', '49')->get();


        //////////////////////
        //PRENATAL HIGH BMI AGE 10-14 YEARS
        $prenatal_high_bmi_10_14 =  $maternalCareReportService->pregnant_high_bmi($request, 'HIGH', '10', '14')->get();

        //PRENATAL HIGH BMI AGE 15-19 YEARS
        $prenatal_high_bmi_15_19 =  $maternalCareReportService->pregnant_high_bmi($request, 'HIGH', '15', '19')->get();

        //PRENATAL HIGH BMI AGE 20-49 YEARS
        $prenatal_high_bmi_20_49 =  $maternalCareReportService->pregnant_high_bmi($request, 'HIGH', '20', '49')->get();


        /////////////////////
        //PREGNANT WITH 2 TD VACCINE AGE 10-14 YEARS
        $pregnant_2_td_vaccine_10_14 =  $maternalCareReportService->pregnant_2_td_vaccine($request, '10', '14')->get();

        //PREGNANT WITH 2 TD VACCINE AGE 15-19 YEARS
        $pregnant_2_td_vaccine_15_19 =  $maternalCareReportService->pregnant_2_td_vaccine($request, '15', '19')->get();

        //PREGNANT WITH 2 TD VACCINE AGE 20-49 YEARS
        $pregnant_2_td_vaccine_20_49 =  $maternalCareReportService->pregnant_2_td_vaccine($request, '20', '49')->get();

        /////////////////////
        //PREGNANT WITH 180 IRON FOLIC ACID AGE 10-14 YEARS
        $pregnant_with_180_iron_folic_10_14 =  $maternalCareReportService->pregnant_iron_folic($request, '10', '14')->get();

        //PREGNANT WITH 180 IRON FOLIC ACID AGE 15-19 YEARS
        $pregnant_with_180_iron_folic_15_19 =  $maternalCareReportService->pregnant_iron_folic($request, '15', '19')->get();

        //PREGNANT WITH 180 IRON FOLIC ACID AGE 20-49 YEARS
        $pregnant_with_180_iron_folic_20_49 =  $maternalCareReportService->pregnant_iron_folic($request, '20', '49')->get();

        /////////////////////
        //PREGNANT WITH 480 CALCIUM CARBONATE AGE 10-14 YEARS
        $pregnant_with_480_calcium_carbonate_10_14 =  $maternalCareReportService->pregnant_calcium_carbonate($request, '10', '14')->get();

        //PREGNANT WITH 480 CALCIUM CARBONATE AGE 15-19 YEARS
        $pregnant_with_480_calcium_carbonate_15_19 =  $maternalCareReportService->pregnant_calcium_carbonate($request, '15', '19')->get();

        //PREGNANT WITH 480 CALCIUM CARBONATE AGE 20-49 YEARS
        $pregnant_with_480_calcium_carbonate_20_49 =  $maternalCareReportService->pregnant_calcium_carbonate($request, '20', '49')->get();


        /////////////////////
        //PREGNANT WITH 2 IODINE CAPSULE AGE 10-14 YEARS
        $pregnant_with_2_iodine_capsule_10_14 =  $maternalCareReportService->pregnant_iodine_capsule($request, '10', '14')->get();

        //PREGNANT WITH 2 IODINE CAPSULE AGE 15-19 YEARS
        $pregnant_with_2_iodine_capsule_15_19 =  $maternalCareReportService->pregnant_iodine_capsule($request, '15', '19')->get();

        //PREGNANT WITH 2 IODINE CAPSULE AGE 20-49 YEARS
        $pregnant_with_2_iodine_capsule_20_49 =  $maternalCareReportService->pregnant_iodine_capsule($request, '20', '49')->get();


        /////////////////////
        //PREGNANT WITH 1 DEWORMING TABLET AGE 10-14 YEARS
        $pregnant_with_1_deworming_10_14 =  $maternalCareReportService->pregnant_deworming_tablet($request, '10', '14')->get();

        //PREGNANT WITH 1 DEWORMING TABLET AGE 15-19 YEARS
        $pregnant_with_1_deworming_15_19 =  $maternalCareReportService->pregnant_deworming_tablet($request, '15', '19')->get();

        //PREGNANT WITH 1 DEWORMING TABLET AGE 20-49 YEARS
        $pregnant_with_1_deworming_20_49 =  $maternalCareReportService->pregnant_deworming_tablet($request, '20', '49')->get();


        /////////////////////
        //PREGNANT SCREENED SYPHILIS AGE 10-14 YEARS
        $pregnant_screened_syphilis_10_14 =  $maternalCareReportService->pregnant_syphillis_test('SYPHILIS', $request, '10', '14')->get();

        //PREGNANT SCREENED SYPHILIS AGE 15-19 YEARS
        $pregnant_screened_syphilis_15_19 =  $maternalCareReportService->pregnant_syphillis_test('SYPHILIS' ,$request, '15', '19')->get();

        //PREGNANT SCREENED SYPHILIS AGE 20-49 YEARS
        $pregnant_screened_syphilis_20_49 =  $maternalCareReportService->pregnant_syphillis_test('SYPHILIS', $request, '20', '49')->get();

        /////////////////////
        //PREGNANT SCREENED SYPHILIS POSITIVE AGE 10-14 YEARS
        $pregnant_screened_syphilis_positive_10_14 =  $maternalCareReportService->pregnant_syphillis_test('SYPHILIS+', $request, '10', '14')->get();

        //PREGNANT SCREENED SYPHILIS POSITIVE AGE 15-19 YEARS
        $pregnant_screened_syphilis_positive_15_19 =  $maternalCareReportService->pregnant_syphillis_test('SYPHILIS+' ,$request, '15', '19')->get();

        //PREGNANT SCREENED SYPHILIS POSITIVE AGE 20-49 YEARS
        $pregnant_screened_syphilis_positive_20_49 =  $maternalCareReportService->pregnant_syphillis_test('SYPHILIS+', $request, '20', '49')->get();


        /////////////////////
        //PREGNANT SCREENED HEPATITIS B AGE 10-14 YEARS
        $pregnant_screened_hepatitis_10_14 =  $maternalCareReportService->pregnant_hepatitis_test('HEPATITIS', $request, '10', '14')->get();

        //PREGNANT SCREENED HEPATITIS B AGE 15-19 YEARS
        $pregnant_screened_hepatitis_15_19 =  $maternalCareReportService->pregnant_hepatitis_test('HEPATITIS' ,$request, '15', '19')->get();

        //PREGNANT SCREENED HEPATITIS B AGE 20-49 YEARS
        $pregnant_screened_hepatitis_20_49 =  $maternalCareReportService->pregnant_hepatitis_test('HEPATITIS', $request, '20', '49')->get();


        /////////////////////
        //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 10-14 YEARS
        $pregnant_screened_hepatitis_positive_10_14 =  $maternalCareReportService->pregnant_hepatitis_test('HEPATITIS+', $request, '10', '14')->get();

        //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 15-19 YEARS
        $pregnant_screened_hepatitis_positive_15_19 =  $maternalCareReportService->pregnant_hepatitis_test('HEPATITIS+' ,$request, '15', '19')->get();

        //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 20-49 YEARS
        $pregnant_screened_hepatitis_positive_20_49 =  $maternalCareReportService->pregnant_hepatitis_test('HEPATITIS+', $request, '20', '49')->get();


        /////////////////////
        //PREGNANT SCREENED HIV AGE 10-14 YEARS
        $pregnant_screened_hiv_10_14 =  $maternalCareReportService->pregnant_hiv_test($request, '10', '14')->get();

        //PREGNANT SCREENED HIV AGE 15-19 YEARS
        $pregnant_screened_hiv_15_19 =  $maternalCareReportService->pregnant_hiv_test($request, '15', '19')->get();

        //PREGNANT SCREENED HIV AGE 20-49 YEARS
        $pregnant_screened_hiv_20_49 =  $maternalCareReportService->pregnant_hiv_test($request, '20', '49')->get();


        /////////////////////
        //PREGNANT SCREENED CBC AGE 10-14 YEARS
        $pregnant_screened_cbc_10_14 =  $maternalCareReportService->pregnant_cbc_hct_test('CBC', $request, '10', '14')->get();

        //PREGNANT SCREENED CBC AGE 15-19 YEARS
        $pregnant_screened_cbc_15_19 =  $maternalCareReportService->pregnant_cbc_hct_test('CBC' ,$request, '15', '19')->get();

        //PREGNANT SCREENED CBC AGE 20-49 YEARS
        $pregnant_screened_cbc_20_49 =  $maternalCareReportService->pregnant_cbc_hct_test('CBC', $request, '20', '49')->get();


        /////////////////////
        //PREGNANT SCREENED CBC POSITIVE AGE 10-14 YEARS
        $pregnant_screened_cbc_positive_10_14 =  $maternalCareReportService->pregnant_cbc_hct_test('CBC+', $request, '10', '14')->get();

        //PREGNANT SCREENED CBC POSITIVE AGE 15-19 YEARS
        $pregnant_screened_cbc_positive_15_19 =  $maternalCareReportService->pregnant_cbc_hct_test('CBC+' ,$request, '15', '19')->get();

        //PREGNANT SCREENED CBC POSITIVE AGE 20-49 YEARS
        $pregnant_screened_cbc_positive_20_49 =  $maternalCareReportService->pregnant_cbc_hct_test('CBC+', $request, '20', '49')->get();


        /////////////////////
        //PREGNANT SCREENED GASTRO DIABETES AGE 10-14 YEARS
        $pregnant_screened_gastro_diabetes_10_14 =  $maternalCareReportService->pregnant_gastro_diabetes_hct_test('DIBTS', $request, '10', '14')->get();

        //PREGNANT SCREENED GASTRO DIABETES AGE 15-19 YEARS
        $pregnant_screened_gastro_diabetes_15_19 =  $maternalCareReportService->pregnant_gastro_diabetes_hct_test('DIBTS' ,$request, '15', '19')->get();

        //PREGNANT SCREENED GASTRO DIABETES AGE 20-49 YEARS
        $pregnant_screened_gastro_diabetes_20_49 =  $maternalCareReportService->pregnant_gastro_diabetes_hct_test('DIBTS', $request, '20', '49')->get();


        /////////////////////
        //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 10-14 YEARS
        $pregnant_screened_gastro_diabetes_positive_10_14 =  $maternalCareReportService->pregnant_gastro_diabetes_hct_test('DIBTS+', $request, '10', '14')->get();

        //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 15-19 YEARS
        $pregnant_screened_gastro_diabetes_positive_15_19 =  $maternalCareReportService->pregnant_gastro_diabetes_hct_test('DIBTS+' ,$request, '15', '19')->get();

        //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 20-49 YEARS
        $pregnant_screened_gastro_diabetes_positive_20_49 =  $maternalCareReportService->pregnant_gastro_diabetes_hct_test('DIBTS+', $request, '20', '49')->get();

        return [

            //4 PRENATAL GIVE BIRTH AGE 10-14 YEARS
            'Prenatal_give_birth_10_14' => $prenatal_give_birth_10_14,

            //4 PRENATAL GIVE BIRTH AGE 15-19 YEARS
            'Prenatal_give_birth_15_19' => $prenatal_give_birth_15_19,

            //4 PRENATAL GIVE BIRTH AGE 20-49 YEARS
            'Prenatal_give_birth_20_49' => $prenatal_give_birth_20_49,


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
            //PRENATAL ASSESSED NUTRITION AGE 10-14 YEARS
            'prenatal_assessed_10_14' => $prenatal_assessed_10_14,

            //PRENATAL ASSESSED NUTRITION AGE 15-19 YEARS
            'prenatal_assessed_15_19' => $prenatal_assessed_15_19,

            //PRENATAL ASSESSED NUTRITION AGE 20-49 YEARS
            'prenatal_assessed_20_49' => $prenatal_assessed_20_49,


            ///////////////////////
            //PREGNANT WITH 2 TD VACCINE AGE 10-14 YEARS
            'pregnant_2_TD_vaccine_10_14' => $pregnant_2_td_vaccine_10_14,

            //PREGNANT WITH 2 TD VACCINE AGE 15-19 YEARS
            'pregnant_2_TD_vaccine_15_19' => $pregnant_2_td_vaccine_15_19,

            //PREGNANT WITH 2 TD VACCINE AGE 20-49 YEARS
            'pregnant_2_TD_vaccine_20_49' => $pregnant_2_td_vaccine_20_49,


            ///////////////////////
            //PREGNANT WITH 180 IRON FOLIC ACID AGE 10-14 YEARS
            'pregnant_with_180_iron_folic_10_14' => $pregnant_with_180_iron_folic_10_14,

            //PREGNANT WITH 180 IRON FOLIC ACID AGE 15-19 YEARS
            'pregnant_with_180_iron_folic_15_19' =>  $pregnant_with_180_iron_folic_15_19,

            //PREGNANT WITH 180 IRON FOLIC ACID AGE 20-49 YEARS
            'pregnant_with_180_iron_folic_20_49' => $pregnant_with_180_iron_folic_20_49,


            ///////////////////////
            //PREGNANT WITH 2 IODINE CAPSULE AGE 10-14 YEARS
            'pregnant_with_2_iodine_capsule_10_14' => $pregnant_with_2_iodine_capsule_10_14,

            //PREGNANT WITH 2 IODINE CAPSULE AGE 15-19 YEARS
            'pregnant_with_2_iodine_capsule_15_19' =>  $pregnant_with_2_iodine_capsule_15_19,

            //PREGNANT WITH 2 IODINE CAPSULE AGE 20-49 YEARSS
            'pregnant_with_2_iodine_capsule_20_49' => $pregnant_with_2_iodine_capsule_20_49,


            ///////////////////////
            //PREGNANT WITH 1 DEWORMING TABLET AGE 10-14 YEARS
            'pregnant_with_1_deworming_10_14' => $pregnant_with_1_deworming_10_14,

            //PREGNANT WITH 1 DEWORMING TABLET AGE 15-19 YEARS
            'pregnant_with_1_deworming_15_19' =>  $pregnant_with_1_deworming_15_19,

            //PREGNANT WITH 1 DEWORMING TABLET AGE 20-49 YEARS
            'pregnant_with_1_deworming_20_49' => $pregnant_with_1_deworming_20_49,


            ///////////////////////
            //PREGNANT SCREENED SYPHILIS AGE 10-14 YEARS
            'pregnant_screened_syphilis_10_14' => $pregnant_screened_syphilis_10_14,

            //PREGNANT SCREENED SYPHILIS AGE 15-19 YEARS
            'pregnant_screened_syphilis_15_19' =>  $pregnant_screened_syphilis_15_19,

            //PREGNANT SCREENED SYPHILIS AGE 20-49 YEARS
            'pregnant_screened_syphilis_20_49' => $pregnant_screened_syphilis_20_49,


            ///////////////////////
            //PREGNANT SCREENED SYPHILIS POSITIVE AGE 10-14 YEARS
            'pregnant_screened_syphilis_positive_10_14' => $pregnant_screened_syphilis_positive_10_14,

            //PREGNANT SCREENED SYPHILIS POSITIVE AGE 15-19 YEARS
            'pregnant_screened_syphilis_positive_15_19' =>  $pregnant_screened_syphilis_positive_15_19,

            //PREGNANT SCREENED SYPHILIS POSITIVE AGE 20-49 YEARS
            'pregnant_screened_syphilis_positive_20_49' => $pregnant_screened_syphilis_positive_20_49,


            ///////////////////////
            //PREGNANT SCREENED HEPATITIS B AGE 10-14 YEARS
            'pregnant_screened_hepatitis_10_14' => $pregnant_screened_hepatitis_10_14,

            //PREGNANT SCREENED HEPATITIS B AGE 15-19 YEARS
            'pregnant_screened_hepatitis_15_19' =>  $pregnant_screened_hepatitis_15_19,

            //PREGNANT SCREENED HEPATITIS B AGE 20-49 YEARS
            'pregnant_screened_hepatitis_20_49' => $pregnant_screened_hepatitis_20_49,


            ///////////////////////
            //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 10-14 YEARS
            'pregnant_screened_hepatitis_positive_10_14' => $pregnant_screened_hepatitis_positive_10_14,

            //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 15-19 YEARS
            'pregnant_screened_hepatitis_positive_15_19' =>  $pregnant_screened_hepatitis_positive_15_19,

            //PREGNANT SCREENED HEPATITIS B POSITIVE AGE 20-49 YEARS
            'pregnant_screened_hepatitis_positive_20_49' => $pregnant_screened_hepatitis_positive_20_49,


            ///////////////////////
            //PREGNANT SCREENED HIV AGE 10-14 YEARS
            'pregnant_screened_hiv_10_14' => $pregnant_screened_hiv_10_14,

            //PREGNANT SCREENED HIV AGE 15-19 YEARS
            'pregnant_screened_hiv_15_19' =>  $pregnant_screened_hiv_15_19,

            //PREGNANT SCREENED HIV AGE 20-49 YEARS
            'pregnant_screened_hiv_20_49' => $pregnant_screened_hiv_20_49,


            ///////////////////////
            //PREGNANT SCREENED CBC AGE 10-14 YEARS
            'pregnant_screened_cbc_10_14' => $pregnant_screened_cbc_10_14,

            //PREGNANT SCREENED CBC AGE 15-19 YEARS
            'pregnant_screened_cbc_15_19' =>  $pregnant_screened_cbc_15_19,

            //PREGNANT SCREENED CBC AGE 20-49 YEARS
            'pregnant_screened_cbc_20_49' => $pregnant_screened_cbc_20_49,


            ///////////////////////
            //PREGNANT SCREENED CBC POSITIVE AGE 10-14 YEARS
            'pregnant_screened_cbc_positive_10_14' => $pregnant_screened_cbc_positive_10_14,

            //PREGNANT SCREENED CBC POSITIVE AGE 15-19 YEARS
            'pregnant_screened_cbc_positive_15_19' =>  $pregnant_screened_cbc_positive_15_19,

            //PREGNANT SCREENED CBC POSITIVE AGE 20-49 YEARS
            'pregnant_screened_cbc_positive_20_49' => $pregnant_screened_cbc_positive_20_49,


            ///////////////////////
            //PREGNANT SCREENED GASTRO DIABETES AGE 10-14 YEARS
            'pregnant_screened_gastro_diabetes_10_14' => $pregnant_screened_gastro_diabetes_10_14,

            //PREGNANT SCREENED GASTRO DIABETES AGE 15-19 YEARS
            'pregnant_screened_gastro_diabetes_15_19' =>  $pregnant_screened_gastro_diabetes_15_19,

            //PREGNANT SCREENED GASTRO DIABETES AGE 20-49 YEARS
            'pregnant_screened_gastro_diabetes_20_49' => $pregnant_screened_gastro_diabetes_20_49,


            ///////////////////////
            //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 10-14 YEARS
            'pregnant_screened_gastro_diabetes_positive_10_14' => $pregnant_screened_gastro_diabetes_positive_10_14,

            //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 15-19 YEARS
            'pregnant_screened_gastro_diabetes_positive_15_19' =>  $pregnant_screened_gastro_diabetes_positive_15_19,

            //PREGNANT SCREENED GASTRO DIABETES POSITIVE AGE 20-49 YEARS
            'pregnant_screened_gastro_diabetes_positive_20_49' => $pregnant_screened_gastro_diabetes_positive_20_49,

            ];
    }

    /**
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
