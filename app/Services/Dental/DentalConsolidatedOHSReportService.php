<?php

namespace App\Services\Dental;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use Illuminate\Support\Facades\DB;

class DentalConsolidatedOHSReportService
{
    public function get_projected_population()
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw('
                    year,
                    SUM(settings_catchment_barangays.population) AS total_population
                    ')
            ->whereFacilityCode(auth()->user()->facility_code)
            ->groupBy('facility_code');
    }

    public function get_catchment_barangays()
    {
        $result = DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code
                    ')
            ->whereFacilityCode(auth()->user()->facility_code);

        return $result->pluck('barangay_code');
    }

    public function get_all_brgy_municipalities_patient()
    {
        return DB::table('municipalities')
            ->selectRaw("
                        patient_id,
                        CONCAT(household_folders.address, ',', ' ', barangays.name, ',', ' ', municipalities.name) AS address,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.psgc_10_digit_code AS barangay_code
                    ")
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.psgc_10_digit_code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id');
    }

    public function get_dental_consolidated_report($request)
    {
        return DB::table('consults')
            ->selectRaw("
                    	SUM(
                            CASE WHEN is_pregnant = 1
                                AND allergies_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_allergies,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND hypertension_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_hypertension,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND diabetes_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_diabetes,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND blood_disorder_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_blood_disorder,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND heart_disease_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_heart_disease,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND thyroid_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_thyroid,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND hepatitis_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_hepatitis,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND malignancy_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_malignancy,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND blood_transfusion_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_blood_transfusion,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND tattoo_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_blood_tattoo,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND sweet_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_sugar_sweetened,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND alcohol_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_alcohol,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND tabacco_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_tobacco,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND nut_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_nut,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND dental_caries_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_dental_carries,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND gingivitis_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_gingivitis,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND periodontal_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_periodontal,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND debris_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_debris,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND calculus_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_calculus,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND dento_facial_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_dento_facial,
                        SUM(
                            CASE WHEN is_pregnant = 1
                                AND dental_caries_flag = 1 THEN
                                1
                            ELSE
                                0
                            END) AS pregnant_women_with_dental_carries,
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
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS female_infant_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 1 THEN
                                1
                            ELSE
                                0
                            END) AS female_1_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 2 THEN
                                1
                            ELSE
                                0
                            END) AS female_2_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 3 THEN
                                1
                            ELSE
                                0
                            END) AS female_3_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_4_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive__with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_underfive_with_dental_carries,
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
                            END) AS male_5_year_old_with_blood_tattoo,
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_blood_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_alcohol,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS female_5_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
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
                            END) AS male_6_year_old_with_blood_tattoo,
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_blood_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_alcohol,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS female_6_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
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
                            END) AS male_7_year_old_with_blood_tattoo,
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_blood_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_alcohol,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS female_7_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
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
                            END) AS male_8_year_old_with_blood_tattoo,
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_blood_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_alcohol,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS female_8_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
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
                            END) AS male_9_year_old_with_blood_tattoo,
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_blood_transfusion,
                        SUM(
                            CASE WHEN tattoo_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_blood_tattoo,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_sugar_sweetened,
                        SUM(
                            CASE WHEN alcohol_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_alcohol,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_9_year_old_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
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
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS male_total_school_age_with_sugar_sweetened,
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
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_allergies,
                        SUM(
                            CASE WHEN hypertension_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_hypertension,
                        SUM(
                            CASE WHEN diabetes_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_diabetes,
                        SUM(
                            CASE WHEN blood_disorder_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_blood_disorder,
                        SUM(
                            CASE WHEN heart_disease_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_heart_disease,
                        SUM(
                            CASE WHEN thyroid_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_thyroid,
                        SUM(
                            CASE WHEN hepatitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_hepatitis,
                        SUM(
                            CASE WHEN malignancy_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_malignancy,
                        SUM(
                            CASE WHEN blood_transfusion_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_blood_transfusion,
                        SUM(
                            CASE WHEN sweet_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_sugar_sweetened,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_dental_carries,
                        SUM(
                            CASE WHEN gingivitis_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_gingivitis,
                        SUM(
                            CASE WHEN periodontal_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_periodontal,
                        SUM(
                            CASE WHEN debris_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_debris,
                        SUM(
                            CASE WHEN calculus_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_calculus,
                        SUM(
                            CASE WHEN dento_facial_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_dento_facial,
                        SUM(
                            CASE WHEN dental_caries_flag = 1
                                AND patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS female_total_school_age_with_dental_carries
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('dental_oral_health_conditions', 'consults.id', '=', 'dental_oral_health_conditions.consult_id')
            ->leftJoin('dental_medical_socials', 'dental_oral_health_conditions.patient_id', '=', 'dental_medical_socials.patient_id')
//            ->leftJoin('dental_tooth_conditions', 'consults.id', '=', 'dental_tooth_conditions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consults.facility_code', auth()->user()->facility_code);
            })
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            });
    }

    public function get_tooth_condition($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_5_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_5_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_6_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_6_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_7_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_7_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_8_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_8_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_9_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_9_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_male_total,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_female_total,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_adolescent_male,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_adolescent_female,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_adult_male,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_adult_female,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_senior_male,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_senior_female,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_tota_all_ages_male,
                        SUM(
                            CASE WHEN tooth_condition = 'D'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS decayed_tooth_tota_all_ages_female,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_5_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_5_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_6_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_6_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_7_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_7_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_8_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_8_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_9_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_9_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_male_total,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_female_total,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_adolescent_male,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_adolescent_female,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_adult_male,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_adult_female,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_senior_male,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_senior_female,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_tota_all_ages_male,
                        SUM(
                            CASE WHEN tooth_condition = 'M'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS missing_tooth_tota_all_ages_female,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_5_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_5_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_6_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 6 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_6_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_7_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 7 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_7_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_8_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 8 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_8_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_9_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) = 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_9_years_old,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_male_total,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_female_total,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_adolescent_male,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_adolescent_female,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_adult_male,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_adult_female,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_senior_male,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_senior_female,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'M'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_tota_all_ages_male,
                        SUM(
                            CASE WHEN tooth_condition = 'F'
                                AND patients.gender = 'F'
                                AND dental_tooth_conditions.tooth_number IN('11', '12', '13', '14', '15', '16', '17', '18', '21', '22', '23', '24', '25', '26', '27', '28', '41', '42', '43', '44', '45', '46', '47', '48', '31', '32', '33', '34', '35', '36', '37', '38')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 5 THEN
                                1
                            ELSE
                                0
                            END) AS filled_tooth_tota_all_ages_female
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('dental_tooth_conditions', 'consults.id', '=', 'dental_tooth_conditions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consults.facility_code', auth()->user()->facility_code);
            })
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            });
    }
}
