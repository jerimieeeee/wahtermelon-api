<?php

namespace App\Http\Controllers\API\V1\Reports\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Services\GenderBasedViolence\GenderBasedViolenceReportService;
use Illuminate\Http\Request;

class GenderBasedViolenceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GenderBasedViolenceReportService $genderBasedViolenceReportService)
    {
        //SEXUAL ABUSE FEMALE
        $sexual_abuse_female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '0', '5', 'SUM(sexual_abuse_flag) AS sexual_abuse_count', 'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '6', '9', 'SUM(sexual_abuse_flag) AS sexual_abuse_count', 'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '10', '17', 'SUM(sexual_abuse_flag) AS sexual_abuse_count', 'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '18', '19', 'SUM(sexual_abuse_flag) AS sexual_abuse_count', 'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_female_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '20', '59', 'SUM(sexual_abuse_flag) AS sexual_abuse_count',  'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_female_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '60', '200', 'SUM(sexual_abuse_flag) AS sexual_abuse_count',  'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');


        /////////////////////////////////
        //SEXUAL ABUSE MALE
        $sexual_abuse_male_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '0', '5', 'SUM(sexual_abuse_flag) AS sexual_abuse_count', 'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_male_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '6', '9', 'SUM(sexual_abuse_flag) AS sexual_abuse_count', 'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_male_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '10', '17', 'SUM(sexual_abuse_flag) AS sexual_abuse_count', 'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_male_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '18', '19', 'SUM(sexual_abuse_flag) AS sexual_abuse_count', 'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_male_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '20', '59', 'SUM(sexual_abuse_flag) AS sexual_abuse_count',  'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');

        $sexual_abuse_male_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '60', '200', 'SUM(sexual_abuse_flag) AS sexual_abuse_count',  'sexual_abuse_count')
            ->get()
            ->pluck('sexual_abuse_count', 'barangay_name');


        /////////////////////////////////
        //PHYSICAL ABUSE FEMALE
        $physical_abuse_female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '0', '5', 'SUM(physical_abuse_flag) AS physical_abuse_count', 'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '6', '9', 'SUM(physical_abuse_flag) AS physical_abuse_count', 'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '10', '17', 'SUM(physical_abuse_flag) AS physical_abuse_count', 'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '18', '19', 'SUM(physical_abuse_flag) AS physical_abuse_count', 'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_female_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '20', '59', 'SUM(physical_abuse_flag) AS physical_abuse_count',  'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_female_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '60', '200', 'SUM(physical_abuse_flag) AS physical_abuse_count',  'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');


        /////////////////////////////////
        //PHYSICAL ABUSE MALE
        $physical_abuse_male_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '0', '5', 'SUM(physical_abuse_flag) AS physical_abuse_count', 'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_male_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '6', '9', 'SUM(physical_abuse_flag) AS physical_abuse_count', 'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_male_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '10', '17', 'SUM(physical_abuse_flag) AS physical_abuse_count', 'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_male_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '18', '19', 'SUM(physical_abuse_flag) AS physical_abuse_count', 'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_male_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '20', '59', 'SUM(physical_abuse_flag) AS physical_abuse_count',  'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');

        $physical_abuse_male_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '60', '200', 'SUM(physical_abuse_flag) AS physical_abuse_count',  'physical_abuse_count')
            ->get()
            ->pluck('physical_abuse_count', 'barangay_name');


        /////////////////////////////////
        //NEGLECT ABUSE FEMALE
        $neglect_abuse_female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '0', '5', 'SUM(neglect_abuse_flag) AS neglect_abuse_count', 'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '6', '9', 'SUM(neglect_abuse_flag) AS neglect_abuse_count', 'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '10', '17', 'SUM(neglect_abuse_flag) AS neglect_abuse_count', 'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '18', '19', 'SUM(neglect_abuse_flag) AS neglect_abuse_count', 'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_female_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '20', '59', 'SUM(neglect_abuse_flag) AS neglect_abuse_count',  'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_female_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '60', '200', 'SUM(neglect_abuse_flag) AS neglect_abuse_count',  'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');


        /////////////////////////////////
        //NEGLECT ABUSE FEMALE
        $neglect_abuse_male_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '0', '5', 'SUM(neglect_abuse_flag) AS neglect_abuse_count', 'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_male_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '6', '9', 'SUM(neglect_abuse_flag) AS neglect_abuse_count', 'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_male_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '10', '17', 'SUM(neglect_abuse_flag) AS neglect_abuse_count', 'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_male_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '18', '19', 'SUM(neglect_abuse_flag) AS neglect_abuse_count', 'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_male_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '20', '59', 'SUM(neglect_abuse_flag) AS neglect_abuse_count',  'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');

        $neglect_abuse_male_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '60', '200', 'SUM(neglect_abuse_flag) AS neglect_abuse_count',  'neglect_abuse_count')
            ->get()
            ->pluck('neglect_abuse_count', 'barangay_name');


        /////////////////////////////////
        //EMOTIONAL ABUSE FEMALE
        $emotional_abuse_female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '0', '5', 'SUM(emotional_abuse_flag) AS emotional_abuse_count', 'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '6', '9', 'SUM(emotional_abuse_flag) AS emotional_abuse_count', 'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '10', '17', 'SUM(emotional_abuse_flag) AS emotional_abuse_count', 'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '18', '19', 'SUM(emotional_abuse_flag) AS emotional_abuse_count', 'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_female_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '20', '59', 'SUM(emotional_abuse_flag) AS emotional_abuse_count',  'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_female_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '60', '200', 'SUM(emotional_abuse_flag) AS emotional_abuse_count',  'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');


        /////////////////////////////////
        //EMOTIONAL ABUSE MALE
        $emotional_abuse_male_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '0', '5', 'SUM(emotional_abuse_flag) AS emotional_abuse_count', 'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_male_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '6', '9', 'SUM(emotional_abuse_flag) AS emotional_abuse_count', 'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_male_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '10', '17', 'SUM(emotional_abuse_flag) AS emotional_abuse_count', 'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_male_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '18', '19', 'SUM(emotional_abuse_flag) AS emotional_abuse_count', 'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_male_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '20', '59', 'SUM(emotional_abuse_flag) AS emotional_abuse_count',  'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');

        $emotional_abuse_male_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '60', '200', 'SUM(emotional_abuse_flag) AS emotional_abuse_count',  'emotional_abuse_count')
            ->get()
            ->pluck('emotional_abuse_count', 'barangay_name');


        /////////////////////////////////
        //ECONOMIC ABUSE FEMALE
        $economic_abuse_female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '0', '5', 'SUM(economic_abuse_flag) AS economic_abuse_count', 'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '6', '9', 'SUM(economic_abuse_flag) AS economic_abuse_count', 'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '10', '17', 'SUM(economic_abuse_flag) AS economic_abuse_count', 'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '18', '19', 'SUM(economic_abuse_flag) AS economic_abuse_count', 'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_female_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '20', '59', 'SUM(economic_abuse_flag) AS economic_abuse_count',  'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_female_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '60', '200', 'SUM(economic_abuse_flag) AS economic_abuse_count',  'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');


        /////////////////////////////////
        //ECONOMIC ABUSE FEMALE
        $economic_abuse_male_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '0', '5', 'SUM(economic_abuse_flag) AS economic_abuse_count', 'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_male_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '6', '9', 'SUM(economic_abuse_flag) AS economic_abuse_count', 'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_male_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '10', '17', 'SUM(economic_abuse_flag) AS economic_abuse_count', 'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_male_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '18', '19', 'SUM(economic_abuse_flag) AS economic_abuse_count', 'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_male_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '20', '59', 'SUM(economic_abuse_flag) AS economic_abuse_count',  'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');

        $economic_abuse_male_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '60', '200', 'SUM(economic_abuse_flag) AS economic_abuse_count',  'economic_abuse_count')
            ->get()
            ->pluck('economic_abuse_count', 'barangay_name');


        /////////////////////////////////
        //UNABLE TO VALIDATE ABUSE FEMALE
        $utv_abuse_female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '0', '5', 'SUM(utv_abuse_flag) AS utv_abuse_count', 'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '6', '9', 'SUM(utv_abuse_flag) AS utv_abuse_count', 'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '10', '17', 'SUM(utv_abuse_flag) AS utv_abuse_count', 'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '18', '19', 'SUM(utv_abuse_flag) AS utv_abuse_count', 'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_female_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '20', '59', 'SUM(utv_abuse_flag) AS utv_abuse_count',  'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_female_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '60', '200', 'SUM(utv_abuse_flag) AS utv_abuse_count',  'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');


        /////////////////////////////////
        //UNABLE TO VALIDATE ABUSE MALE
        $utv_abuse_male_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '0', '5', 'SUM(utv_abuse_flag) AS utv_abuse_count', 'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_male_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '6', '9', 'SUM(utv_abuse_flag) AS utv_abuse_count', 'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_male_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '10', '17', 'SUM(utv_abuse_flag) AS utv_abuse_count', 'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_male_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '18', '19', 'SUM(utv_abuse_flag) AS utv_abuse_count', 'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_male_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '20', '59', 'SUM(utv_abuse_flag) AS utv_abuse_count',  'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');

        $utv_abuse_male_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '60', '200', 'SUM(utv_abuse_flag) AS utv_abuse_count',  'utv_abuse_count')
            ->get()
            ->pluck('utv_abuse_count', 'barangay_name');


        /////////////////////////////////
        //MULTIPLE TO VALIDATE ABUSE FEMALE
        $multiple_abuse_female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'F', '0', '5')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'F', '6', '9')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'F', '10', '17')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'F', '18', '19')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_female_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'F', '20', '59')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_female_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'F', '60', '200')
            ->get()
            ->pluck('count', 'barangay_name');


        /////////////////////////////////
        //MULTIPLE ABUSE FEMALE
        $multiple_abuse_male_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'M', '0', '5')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_male_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'M', '6', '9')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_male_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'M', '10', '17')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_male_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'M', '18', '19')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_male_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'M', '20', '59')
            ->get()
            ->pluck('count', 'barangay_name');

        $multiple_abuse_male_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses2($request, 'M', '60', '200')
            ->get()
            ->pluck('count', 'barangay_name');


        /////////////////////////////////
        //OTHERS ABUSE FEMALE
        $others_abuse_female_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '0', '5', 'SUM(others_abuse_flag) AS others_abuse_count', 'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_female_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '6', '9', 'SUM(others_abuse_flag) AS others_abuse_count', 'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_female_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '10', '17', 'SUM(others_abuse_flag) AS others_abuse_count', 'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_female_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '18', '19', 'SUM(others_abuse_flag) AS others_abuse_count', 'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_female_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '20', '59', 'SUM(others_abuse_flag) AS others_abuse_count',  'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_female_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'F', '60', '200', 'SUM(others_abuse_flag) AS others_abuse_count',  'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');


        /////////////////////////////////
        //OTHERS ABUSE MALE
        $others_abuse_male_age_0_to_5 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '0', '5', 'SUM(others_abuse_flag) AS others_abuse_count', 'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_male_age_6_to_9 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '6', '9', 'SUM(others_abuse_flag) AS others_abuse_count', 'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_male_age_10_to_17 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '10', '17', 'SUM(others_abuse_flag) AS others_abuse_count', 'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_male_age_18_to_19 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '18', '19', 'SUM(others_abuse_flag) AS others_abuse_count', 'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_male_age_20_to_59 = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '20', '59', 'SUM(others_abuse_flag) AS others_abuse_count',  'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');

        $others_abuse_male_age_60_and_above = $genderBasedViolenceReportService->get_gbv_catalyst_report_abuses($request, 'M', '60', '200', 'SUM(others_abuse_flag) AS others_abuse_count',  'others_abuse_count')
            ->get()
            ->pluck('others_abuse_count', 'barangay_name');



        return [

            //SEXUAL ABUSE MALE & FEMALE
            'sexual_abuse' => ['female_age_0_to_5' => $sexual_abuse_female_age_0_to_5,
                               'male_age_0_to_5' => $sexual_abuse_male_age_0_to_5,
                               'female_age_6_to_9' => $sexual_abuse_female_age_6_to_9,
                               'male_age_6_to_9' => $sexual_abuse_male_age_6_to_9,
                               'female_age_10_to_17' => $sexual_abuse_female_age_10_to_17,
                               'male_age_10_to_17' => $sexual_abuse_male_age_10_to_17,
                               'female_age_18_to_19' => $sexual_abuse_female_age_18_to_19,
                               'male_age_18_to_19' => $sexual_abuse_male_age_18_to_19,
                               'female_age_20_to_59' => $sexual_abuse_female_age_20_to_59,
                               'male_age_20_to_59' => $sexual_abuse_male_age_20_to_59,
                               'female_age_60_and_above' => $sexual_abuse_female_age_60_and_above,
                               'male_age_60_and_above' => $sexual_abuse_male_age_60_and_above
                            ],

            //PHYSICAL ABUSE MALE & FEMALE
            'physical_abuse' => ['female_age_0_to_5' => $physical_abuse_female_age_0_to_5,
                                'male_age_0_to_5' => $physical_abuse_male_age_0_to_5,
                                'female_age_6_to_9' => $physical_abuse_female_age_6_to_9,
                                'male_age_6_to_9' => $physical_abuse_male_age_6_to_9,
                                'female_age_10_to_17' => $physical_abuse_female_age_10_to_17,
                                'male_age_10_to_17' => $physical_abuse_male_age_10_to_17,
                                'female_age_18_to_19' => $physical_abuse_female_age_18_to_19,
                                'male_age_18_to_19' => $physical_abuse_male_age_18_to_19,
                                'female_age_20_to_59' => $physical_abuse_female_age_20_to_59,
                                'male_age_20_to_59' => $physical_abuse_male_age_20_to_59,
                                'female_age_60_and_above' => $physical_abuse_female_age_60_and_above,
                                'male_age_60_and_above' => $physical_abuse_male_age_60_and_above
            ],

            //NEGLECT ABUSE MALE & FEMALE
            'neglect_abuse' => ['female_age_0_to_5' => $neglect_abuse_female_age_0_to_5,
                                'male_age_0_to_5' => $neglect_abuse_male_age_0_to_5,
                                'female_age_6_to_9' => $neglect_abuse_female_age_6_to_9,
                                'male_age_6_to_9' => $neglect_abuse_male_age_6_to_9,
                                'female_age_10_to_17' => $neglect_abuse_female_age_10_to_17,
                                'male_age_10_to_17' => $neglect_abuse_male_age_10_to_17,
                                'female_age_18_to_19' => $neglect_abuse_female_age_18_to_19,
                                'male_age_18_to_19' => $neglect_abuse_male_age_18_to_19,
                                'female_age_20_to_59' => $neglect_abuse_female_age_20_to_59,
                                'male_age_20_to_59' => $neglect_abuse_male_age_20_to_59,
                                'female_age_60_and_above' => $neglect_abuse_female_age_60_and_above,
                                'male_age_60_and_above' => $neglect_abuse_male_age_60_and_above
            ],

            //EMOTIONAL ABUSE MALE & FEMALE
            'emotional_abuse' => ['female_age_0_to_5' => $emotional_abuse_female_age_0_to_5,
                                  'male_age_0_to_5' => $emotional_abuse_male_age_0_to_5,
                                  'female_age_6_to_9' => $emotional_abuse_female_age_6_to_9,
                                  'male_age_6_to_9' => $emotional_abuse_male_age_6_to_9,
                                  'female_age_10_to_17' => $emotional_abuse_female_age_10_to_17,
                                  'male_age_10_to_17' => $emotional_abuse_male_age_10_to_17,
                                  'female_age_18_to_19' => $emotional_abuse_female_age_18_to_19,
                                  'male_age_18_to_19' => $emotional_abuse_male_age_18_to_19,
                                  'female_age_20_to_59' => $emotional_abuse_female_age_20_to_59,
                                  'male_age_20_to_59' => $emotional_abuse_male_age_20_to_59,
                                  'female_age_60_and_above' => $emotional_abuse_female_age_60_and_above,
                                  'male_age_60_and_above' => $emotional_abuse_male_age_60_and_above
            ],

            //ECONOMIC ABUSE MALE & FEMALE
            'economic_abuse' => ['female_age_0_to_5' => $economic_abuse_female_age_0_to_5,
                                'male_age_0_to_5' => $economic_abuse_male_age_0_to_5,
                                'female_age_6_to_9' => $economic_abuse_female_age_6_to_9,
                                'male_age_6_to_9' => $economic_abuse_male_age_6_to_9,
                                'female_age_10_to_17' => $economic_abuse_female_age_10_to_17,
                                'male_age_10_to_17' => $economic_abuse_male_age_10_to_17,
                                'female_age_18_to_19' => $economic_abuse_female_age_18_to_19,
                                'male_age_18_to_19' => $economic_abuse_male_age_18_to_19,
                                'female_age_20_to_59' => $economic_abuse_female_age_20_to_59,
                                'male_age_20_to_59' => $economic_abuse_male_age_20_to_59,
                                'female_age_60_and_above' => $economic_abuse_female_age_60_and_above,
                                'male_age_60_and_above' => $economic_abuse_male_age_60_and_above
            ],

            //UNABLE TO VALIDATE ABUSE MALE & FEMALE
            'utv_abuse' => ['female_age_0_to_5' => $utv_abuse_female_age_0_to_5,
                            'male_age_0_to_5' => $utv_abuse_male_age_0_to_5,
                            'female_age_6_to_9' => $utv_abuse_female_age_6_to_9,
                            'male_age_6_to_9' => $utv_abuse_male_age_6_to_9,
                            'female_age_10_to_17' => $utv_abuse_female_age_10_to_17,
                            'male_age_10_to_17' => $utv_abuse_male_age_10_to_17,
                            'female_age_18_to_19' => $utv_abuse_female_age_18_to_19,
                            'male_age_18_to_19' => $utv_abuse_male_age_18_to_19,
                            'female_age_20_to_59' => $utv_abuse_female_age_20_to_59,
                            'male_age_20_to_59' => $utv_abuse_male_age_20_to_59,
                            'female_age_60_and_above' => $utv_abuse_female_age_60_and_above,
                            'male_age_60_and_above' => $utv_abuse_male_age_60_and_above
            ],

            //MULTIPLE ABUSE MALE & FEMALE
            'multiple_abuse' => ['female_age_0_to_5' => $multiple_abuse_female_age_0_to_5,
                                'male_age_0_to_5' => $multiple_abuse_male_age_0_to_5,
                                'female_age_6_to_9' => $multiple_abuse_female_age_6_to_9,
                                'male_age_6_to_9' => $multiple_abuse_male_age_6_to_9,
                                'female_age_10_to_17' => $multiple_abuse_female_age_10_to_17,
                                'male_age_10_to_17' => $multiple_abuse_male_age_10_to_17,
                                'female_age_18_to_19' => $multiple_abuse_female_age_18_to_19,
                                'male_age_18_to_19' => $multiple_abuse_male_age_18_to_19,
                                'female_age_20_to_59' => $multiple_abuse_female_age_20_to_59,
                                'male_age_20_to_59' => $multiple_abuse_male_age_20_to_59,
                                'female_age_60_and_above' => $multiple_abuse_female_age_60_and_above,
                                'male_age_60_and_above' => $multiple_abuse_male_age_60_and_above
            ],

            //OTHERS ABUSE MALE & FEMALE
            'others_abuse' => ['female_age_0_to_5' => $others_abuse_female_age_0_to_5,
                               'male_age_0_to_5' => $others_abuse_male_age_0_to_5,
                               'female_age_6_to_9' => $others_abuse_female_age_6_to_9,
                               'male_age_6_to_9' => $others_abuse_male_age_6_to_9,
                               'female_age_10_to_17' => $others_abuse_female_age_10_to_17,
                               'male_age_10_to_17' => $others_abuse_male_age_10_to_17,
                               'female_age_18_to_19' => $others_abuse_female_age_18_to_19,
                               'male_age_18_to_19' => $others_abuse_male_age_18_to_19,
                               'female_age_20_to_59' => $others_abuse_female_age_20_to_59,
                               'male_age_20_to_59' => $others_abuse_male_age_20_to_59,
                               'female_age_60_and_above' => $others_abuse_female_age_60_and_above,
                               'male_age_60_and_above' => $others_abuse_male_age_60_and_above
            ],
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
