<?php

namespace App\Services\Morbidity;

use Illuminate\Support\Facades\DB;

class MorbidityReportService
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

    public function get_morbidity_report_all($request)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                    icd10_desc AS description,
                    consult_notes_final_dxes.icd10_code AS icd10_code,
                    SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, patients.birthdate) BETWEEN 0 AND 6)
                            AND patients.gender = 'M'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'male_age_0_to_6_days',
                            SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, patients.birthdate) BETWEEN 0 AND 6)
                            AND patients.gender = 'F'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'female_age_0_to_6_days',
                     SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, patients.birthdate) BETWEEN 7 AND 28)
                            AND patients.gender = 'M'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'male_age_7_to_28_days',
                     SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, patients.birthdate) BETWEEN 7 AND 28)
                            AND patients.gender = 'F'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'female_age_7_to_28_days',
                    SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, patients.birthdate) >= 29)
                            AND (TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) <= 11)
                            AND patients.gender = 'M'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'male_age_29_days_to_11_months',
                    SUM(
                        CASE
                            WHEN (DATEDIFF(consult_date, patients.birthdate) >= 29)
                            AND (TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) <= 11)
                            AND patients.gender = 'F'
                            THEN
                                1
                            ELSE
                                0
                        END) AS 'female_age_29_days_to_11_months',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_1_to_4_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_1_to_4_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_5_to_9_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_5_to_9_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_10_to_14_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_10_to_14_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_15_to_19_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_15_to_19_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 24)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_20_to_24_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 24)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_20_to_24_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 25 AND 29)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_25_to_29_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 25 AND 29)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_25_to_29_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 30 AND 34)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_30_to_34_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 30 AND 34)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_30_to_34_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 35 AND 39)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_35_to_39_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 35 AND 39)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_35_to_39_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 40 AND 44)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_40_to_44_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 40 AND 44)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_40_to_44_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 45 AND 49)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_45_to_49_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 45 AND 49)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_45_to_49_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 50 AND 54)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_50_to_54_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 50 AND 54)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_50_to_54_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 55 AND 59)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_55_to_59_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 55 AND 59)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_55_to_59_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 60 AND 64)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_60_to_64_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 60 AND 64)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_60_to_64_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 65 AND 69)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_65_to_69_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 65 AND 69)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_65_to_69_years',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 70)
                        AND patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_70_years_above',
                    SUM(
                        CASE
                        WHEN (TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 70)
                        AND patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_70_years_above',
                    SUM(
                        CASE
                        WHEN patients.gender = 'M'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_age_total',
                    SUM(
                        CASE
                        WHEN patients.gender = 'F'
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'female_age_total',
                    SUM(
                        CASE
                        WHEN patients.gender IN('F', 'M')
                        THEN
                            1
                        ELSE
                            0
                        END) AS 'male_female_total'
                ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('users', 'consult_notes_final_dxes.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code);
            })
            ->where('consult_notes_final_dxes.facility_code', auth()->user()->facility_code)
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
/*            ->whereYear('consult_date', $request->year)
            ->whereMonth('consult_date', $request->month)*/
            ->groupBy('consult_notes_final_dxes.icd10_code')
            ->orderBy('icd10_desc', 'ASC');
    }
}
