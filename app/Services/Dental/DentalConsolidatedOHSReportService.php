<?php

namespace App\Services\Dental;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Services\ReportFilter\CategoryFilterService;
use Illuminate\Support\Facades\DB;

class DentalConsolidatedOHSReportService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_attended_examined($request)
    {
        return DB::table('consults')
            ->selectRaw("
                    	SUM(
                            CASE
                                WHEN is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14  THEN 1
                                ELSE 0
                            END
                        ) AS pregnant_women_10_14_year_old_attended,
                        SUM(
                            CASE
                                WHEN is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19  THEN 1
                                ELSE 0
                            END
                        ) AS pregnant_women_15_19_year_old_attended,
                        SUM(
                            CASE
                                WHEN is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49  THEN 1
                                ELSE 0
                            END
                        ) AS pregnant_women_20_49_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11  THEN 1
                                ELSE 0
                            END
                        ) AS male_infant_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN 1
                                ELSE 0
                            END
                        ) AS male_1_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN 1
                                ELSE 0
                            END
                        ) AS male_2_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN 1
                                ELSE 0
                            END
                        ) AS male_3_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN 1
                                ELSE 0
                            END
                        ) AS male_4_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN 1
                                ELSE 0
                            END
                        ) AS male_total_underfive_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN 1
                                ELSE 0
                            END
                        ) AS male_5_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN 1
                                ELSE 0
                            END
                        ) AS male_6_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN 1
                                ELSE 0
                            END
                        ) AS male_7_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN 1
                                ELSE 0
                            END
                        ) AS male_8_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN 1
                                ELSE 0
                            END
                        ) AS male_9_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN 1
                                ELSE 0
                            END
                        ) AS male_total_school_age_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN 1
                                ELSE 0
                            END
                        ) AS male_adolescent_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN 1
                                ELSE 0
                            END
                        ) AS male_adult_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN 1
                                ELSE 0
                            END
                        ) AS male_senior_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 0 THEN 1
                                ELSE 0
                            END
                        ) AS male_all_age_attended,
                            SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN 1
                                ELSE 0
                            END
                        ) AS female_infant_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN 1
                                ELSE 0
                            END
                        ) AS female_1_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN 1
                                ELSE 0
                            END
                        ) AS female_2_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN 1
                                ELSE 0
                            END
                        ) AS female_3_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN 1
                                ELSE 0
                            END
                        ) AS female_4_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN 1
                                ELSE 0
                            END
                        ) AS female_total_underfive_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN 1
                                ELSE 0
                            END
                        ) AS female_5_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN 1
                                ELSE 0
                            END
                        ) AS female_6_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN 1
                                ELSE 0
                            END
                        ) AS female_7_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN 1
                                ELSE 0
                            END
                        ) AS female_8_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN 1
                                ELSE 0
                            END
                        ) AS female_9_year_old_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN 1
                                ELSE 0
                            END
                        ) AS female_total_school_age_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN 1
                                ELSE 0
                            END
                        ) AS female_adolescent_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN 1
                                ELSE 0
                            END
                        ) AS female_adult_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN 1
                                ELSE 0
                            END
                        ) AS female_senior_attended,
                        SUM(
                            CASE
                                WHEN patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 0 THEN 1
                                ELSE 0
                            END
                        ) AS female_all_age_attended,
                        COUNT(consults.patient_id) AS grand_total_attended,
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'pregnant_women_10_14_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'pregnant_women_15_19_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'pregnant_women_20_49_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'pregnant_women_20_49_year_old_examined',
                            COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_infant_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_1_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_2_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_3_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_4_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_total_underfive_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_5_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_6_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_7_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_8_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_9_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_total_school_age_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_adolescent_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_adult_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_senior_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 0
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'male_all_age_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_infant_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_1_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_2_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_3_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_4_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_total_underfive_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_5_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_6_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_7_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_8_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_9_year_old_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_total_school_age_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_adolescent_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_adult_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_senior_examined',
                        COUNT(
                            DISTINCT CASE
                                WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 0
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END
                        ) AS 'female_all_age_examined',
                        COUNT(DISTINCT consults.patient_id) AS grand_total_examined
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date]);
    }

    public function get_dental_consolidated_report($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND allergies_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_allergies,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND hypertension_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_hypertension,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND diabetes_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_diabetes,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND blood_disorder_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND heart_disease_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND thyroid_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_thyroid,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND hepatitis_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND malignancy_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_malignancy,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND blood_transfusion_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND tattoo_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_tattoo,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND sweet_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND alcohol_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_alcohol,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND tabacco_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_tobacco,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND nut_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_nut,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND dental_caries_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND gingivitis_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND periodontal_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_periodontal,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND debris_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_debris,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND calculus_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_calculus,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND dento_facial_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_10_14_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND allergies_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_allergies,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND hypertension_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_hypertension,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND diabetes_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_diabetes,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND blood_disorder_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND heart_disease_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND thyroid_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_thyroid,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND hepatitis_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND malignancy_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_malignancy,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND blood_transfusion_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND tattoo_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_tattoo,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND sweet_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND alcohol_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_alcohol,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND tabacco_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_tobacco,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND nut_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_nut,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND dental_caries_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND gingivitis_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND periodontal_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_periodontal,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND debris_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_debris,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND calculus_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_calculus,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND dento_facial_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_15_19_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND allergies_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_allergies,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND hypertension_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_hypertension,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND diabetes_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_diabetes,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND blood_disorder_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND heart_disease_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND thyroid_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_thyroid,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND hepatitis_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND malignancy_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_malignancy,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND blood_transfusion_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND tattoo_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_tattoo,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND sweet_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND alcohol_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_alcohol,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND tabacco_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_tobacco,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND nut_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_nut,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND dental_caries_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND gingivitis_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND periodontal_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_periodontal,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND debris_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_debris,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND calculus_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_calculus,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND dento_facial_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_20_49_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS male_infant_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_5_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS male_6_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS male_7_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS male_8_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_9_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'F'

                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_dental_carries,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS male_adolescent_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS female_adolescent_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS male_adult_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS female_adult_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS male_senior_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date)  >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS female_senior_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                            THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_dento_facial,
                        SUM(
                            CASE WHEN allergies_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                            AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_alcohol,
                        SUM(
                            CASE WHEN tabacco_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_tobacco,
                        SUM(
                            CASE WHEN nut_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_nut,
                        SUM(
                            CASE WHEN dental_caries_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_dento_facial,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'M'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_orally_fit,
                        SUM(
                            CASE WHEN orally_fit_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_orally_fit,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS male_1_year_old_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS male_2_year_old_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS male_3_year_old_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_4_year_old_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_underfive_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS male_all_age_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_all_age_with_oral_rehab,
                        SUM(
                            CASE WHEN oral_rehab_flag = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS grand_total_with_oral_rehab
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('dental_oral_health_conditions', 'consults.id', '=', 'dental_oral_health_conditions.consult_id')
            ->leftJoin('dental_medical_socials', 'dental_oral_health_conditions.patient_id', '=', 'dental_medical_socials.patient_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            });
    }

    public function get_adult_tooth_condition($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_pregnant_women_10_14_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_pregnant_women_15_19_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_pregnant_women_20_49_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_adult,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_adult,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_senior,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_senior,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_pregnant_women_10_14_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_pregnant_women_15_19_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_pregnant_women_20_49_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_adult,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_adult,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_senior,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_senior,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_pregnant_women_10_14_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_pregnant_women_15_19_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND is_pregnant = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_pregnant_women_20_49_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_adult,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_adult,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_senior,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_senior,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5
                            THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_grand_total,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5
                            THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_grand_total,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5
                            THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_grand_total
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('dental_tooth_conditions', 'consults.id', '=', 'dental_tooth_conditions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->wherePtGroup('dn')
            ->whereIn('dental_tooth_conditions.tooth_number',
                [
                    '11', '12', '13', '14', '15',
                    '16', '17', '18', '21', '22',
                    '23', '24', '25', '26', '27',
                    '28', '41', '42', '43', '44',
                    '45', '46', '47', '48', '31',
                    '32', '33', '34', '35', '36',
                    '37', '38'
                ]
            )
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            });;
    }

    public function get_temporary_tooth_condition($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_infant,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_infant,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_1_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_1_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_2_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_2_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_3_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_3_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_4_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_4_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_total_underfive,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_total_underfive,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_infant,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_infant,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_1_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_1_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_2_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_2_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_3_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_3_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_4_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_4_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_total_underfive,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_total_underfive,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_5_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_6_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_7_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_8_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_9_year_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_total_school_age,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_adolescent,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_all_age,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                            AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_grand_total,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                            AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_grand_total,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                            AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 0 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_grand_total
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('dental_tooth_conditions', 'consults.id', '=', 'dental_tooth_conditions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->wherePtGroup('dn')
            ->whereIn('dental_tooth_conditions.tooth_number',
                [
                    '51', '52', '53', '54', '55',
                    '61', '62', '63', '64', '65',
                    '81', '82', '83', '84', '85',
                    '71', '72', '73', '74', '75'
                ]
            )
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date]);
    }

    public function get_dental_services($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_10_14_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_10_14_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_10_14_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_10_14_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_10_14_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_10_14_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_10_14_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_15_19_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_15_19_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_15_19_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_15_19_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_15_19_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_15_19_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_15_19_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_20_49_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_20_49_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_20_49_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_20_49_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_20_49_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_20_49_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND is_pregnant = 1
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_20_49_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_infant_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_infant_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_infant_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_infant_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_infant_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_infant_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_infant_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_infant_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_infant_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_infant_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_infant_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_infant_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_1_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_1_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_1_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_1_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_1_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_1_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_1_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_1_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_1_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_1_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_1_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_1_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_1_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_1_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_2_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_2_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_2_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_2_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_2_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_2_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_2_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_2_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  2 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_2_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_2_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  2 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_2_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  2 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_2_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  2 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_2_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  2 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_2_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_3_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_3_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_3_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_3_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_3_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_3_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_3_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_3_year_old_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 15
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_3_year_old_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_3_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_3_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_3_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_3_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_3_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_3_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_3_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_3_year_old_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 15
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_3_year_old_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_4_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_4_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_4_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_4_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_4_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_4_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_4_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_4_year_old_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 15
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_4_year_old_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_4_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_4_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_4_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_4_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_4_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_4_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_4_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) =  4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_4_year_old_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 15
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_4_year_old_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_underfive_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_underfive_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_underfive_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_underfive_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_underfive_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_underfive_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_underfive_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 3 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_underfive_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 15
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 3 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_underfive_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_underfive_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_underfive_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_underfive_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_underfive_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_underfive_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_underfive_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_underfive_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 3 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_underfive_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 15
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 3 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_underfive_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_5_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 10
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_5_year_old_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 15
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_year_old_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_5_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 10
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_5_year_old_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 15
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_year_old_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_6_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_6_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 10
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_6_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_6_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_6_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_6_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_6_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_6_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_6_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_6_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_6_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 10
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_6_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_6_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_6_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_6_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_6_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_6_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_6_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_7_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_7_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 10
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_7_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_7_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_7_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_7_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_7_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_7_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_7_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_7_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_7_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 10
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_7_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_7_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_7_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_7_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_7_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_7_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_7_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_8_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_8_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 10
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_8_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_8_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_8_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_8_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_8_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_8_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_8_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_8_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_8_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 10
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_8_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_8_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_8_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_8_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_8_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_8_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_8_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_9_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_9_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 10
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_9_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_9_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_9_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_9_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_9_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_9_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_9_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_9_year_old_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_9_year_old_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 10
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_9_year_old_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_9_year_old_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_9_year_old_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_9_year_old_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_9_year_old_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_9_year_old_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_9_year_old_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_school_age_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_school_age_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 10
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_school_age_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_school_age_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_school_age_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_school_age_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_school_age_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_school_age_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_school_age_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 15
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_total_school_age_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_school_age_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_school_age_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 10
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_school_age_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_school_age_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_school_age_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_school_age_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_school_age_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_school_age_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_school_age_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 15
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_total_school_age_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adolescent_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adolescent_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adolescent_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adolescent_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adolescent_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adolescent_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adolescent_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adolescent_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adolescent_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adolescent_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adolescent_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adolescent_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adolescent_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adolescent_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adolescent_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adolescent_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adult_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adult_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adult_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adult_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adult_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_adult_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adult_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adult_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adult_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adult_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adult_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adult_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_adult_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adult_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_senior_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_senior_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_senior_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_senior_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_senior_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_senior_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_senior_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_senior_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_senior_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_senior_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_senior_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_senior_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_senior_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_senior_with_counseling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(19, 14)
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_all_age_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_all_age_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 10
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_all_age_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_all_age_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 18 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_all_age_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 3 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_all_age_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 20 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_all_age_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_all_age_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND service_id IN(4, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_all_age_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id = 15
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 3 AND 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_all_age_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(19, 14)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_all_age_with_op_scaling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 5
                                AND (is_pregnant IS NULL OR is_pregnant = 0) THEN
                                1
                            ELSE
                                0
                            END) AS 'female_all_age_with_gum_treatment',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 10
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'female_all_age_with_sealant',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 17
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 19
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'female_all_age_with_flouride',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 18
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'female_all_age_with_post_operative',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 3
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'female_all_age_with_abscess',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 20
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'female_all_age_with_other_services',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 11
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                            THEN
                                1
                            ELSE
                                0
                            END) AS 'female_all_age_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND service_id IN(4, 8)
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_all_age_with_counseling',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id = 15
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 3 AND 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_all_age_with_completed',
                        COUNT(
                            DISTINCT CASE WHEN service_id IN(19, 14)
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'grand_total_with_op_scaling',
                        SUM(
                            CASE WHEN service_id = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'grand_total_with_gum_treatment',
                        SUM(
                            CASE WHEN service_id = 10
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'grand_total_with_sealant',
                        SUM(
                            CASE WHEN service_id = 17
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'grand_total_with_flouride',
                        SUM(
                            CASE WHEN service_id = 18 THEN
                                1
                            ELSE
                                0
                            END) AS 'grand_total_with_post_operative',
                        SUM(
                            CASE WHEN service_id = 3 THEN
                                1
                            ELSE
                                0
                            END) AS 'grand_total_with_abscess',
                        SUM(
                            CASE WHEN service_id = 20 THEN
                                1
                            ELSE
                                0
                            END) AS 'grand_total_with_other_services',
                        SUM(
                            CASE WHEN service_id = 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'grand_total_with_referred',
                        COUNT(
                            DISTINCT CASE WHEN service_id IN(4, 8)
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'grand_total_with_counseling',
                        SUM(
                            CASE WHEN service_id = 15
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 3 AND 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'grand_total_with_completed'
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('dental_services', 'consults.id', '=', 'dental_services.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date]);
    }

    public function get_tooth_services($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_10_14_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_15_19_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_20_49_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_10_14_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_15_19_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_20_49_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_10_14_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_15_19_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_20_49_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND is_pregnant = 1
                                AND dental_tooth_services.service_code = 'X'
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'pregnant_women_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_infant_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_infant_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_infant_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_infant_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_infant_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_infant_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_1_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_1_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_1_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_1_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_1_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_1_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_2_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_2_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_2_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_2_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_2_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_2_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_3_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_3_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_3_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_3_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_3_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_3_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_4_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_4_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_4_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_4_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_4_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_4_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_underfive_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_underfive_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_underfive_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_underfive_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_underfive_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_underfive_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_5_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_5_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_5_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_5_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_5_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_5_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_6_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_6_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_6_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_6_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_6_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_6_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_7_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_7_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_7_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_7_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_7_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_7_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_8_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_8_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_8_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_8_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_8_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_8_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_9_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_9_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_9_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_9_year_old_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_9_year_old_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_9_year_old_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_school_age_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_school_age_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_total_school_age_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_school_age_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_school_age_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_total_school_age_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adolescent_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adolescent_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adolescent_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adolescent_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adolescent_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adolescent_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adult_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adult_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_adult_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adult_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adult_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_adult_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_senior_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_senior_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_senior_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_senior_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_senior_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_senior_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'PF'
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_all_age_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'TF'
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_all_age_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'M'
                                AND dental_tooth_services.service_code = 'X'
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'male_all_age_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'PF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_all_age_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'TF'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_all_age_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN patients.gender = 'F'
                                AND dental_tooth_services.service_code = 'X'
                                AND (is_pregnant IS NULL OR is_pregnant = 0)
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'female_all_age_with_extraction',
                        COUNT(
                            DISTINCT CASE WHEN dental_tooth_services.service_code = 'PF'
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'grand_total_with_permanent_filling',
                        COUNT(
                            DISTINCT CASE WHEN dental_tooth_services.service_code = 'TF'
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'grand_total_with_temporary_filling',
                        COUNT(
                            DISTINCT CASE WHEN dental_tooth_services.service_code = 'X'
                            THEN
                                patients.id
                            ELSE
                                NULL
                            END) AS 'grand_total_with_extraction'
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('dental_tooth_services', 'consults.id', '=', 'dental_tooth_services.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date]);
    }
}
