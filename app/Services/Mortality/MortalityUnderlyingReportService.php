<?php

namespace App\Services\Mortality;

use Illuminate\Support\Facades\DB;

class MortalityUnderlyingReportService
{
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

    public function get_mortality_underlying($request)
    {
        return DB::table('patient_death_records')
            ->selectRaw("
                        icd10_desc AS description,
                        patient_death_record_causes.icd10_code AS icd10_code,
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) BETWEEN 0 AND 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_0_to_6_days',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) BETWEEN 7 AND 28 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_7_to_28_days',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND(TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) = 29
                                    OR TIMESTAMPDIFF(MONTH, patients.birthdate, patient_death_records.date_of_death) BETWEEN 0 AND 11) THEN
                                1
                            ELSE
                                0
                            END) AS 'male_29_days_to_11_months',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_1_to_4_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_to_9_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_10_to_14_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_15_to_19_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 20 AND 24 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_20_to_24_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 25 AND 29 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_25_to_29_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 30 AND 34 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_30_to_34_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 35 AND 39 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_35_to_39_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 40 AND 44 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_40_to_44_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 45 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_45_to_49_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 50 AND 54 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_50_to_54_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 55 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_55_to_59_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 60 AND 64 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_60_to_64_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 65 AND 69 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_65_to_69_years',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) >= 70 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_70_years_above',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) BETWEEN 0 AND 6 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_0_to_6_days',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) BETWEEN 7 AND 28 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_7_to_28_days',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND(TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) = 29
                                    OR TIMESTAMPDIFF(MONTH, patients.birthdate, patient_death_records.date_of_death) BETWEEN 0 AND 11) THEN
                                1
                            ELSE
                                0
                            END) AS 'female_29_days_to_11_months',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_1_to_4_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_to_9_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_10_to_14_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_15_to_19_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 20 AND 24 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_20_to_24_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 25 AND 29 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_25_to_29_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 30 AND 34 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_30_to_34_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 35 AND 39 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_35_to_39_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 40 AND 44 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_40_to_44_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 45 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_45_to_49_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 50 AND 54 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_50_to_54_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 55 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_55_to_59_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 60 AND 64 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_60_to_64_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 65 AND 69 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_65_to_69_years',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) >= 70 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_70_years_above'
                    ")
            ->leftJoin('patient_death_record_causes', 'patient_death_records.id', '=', 'patient_death_record_causes.death_record_id')
            ->join('patients', 'patient_death_records.patient_id', '=', 'patients.id')
            ->join('lib_icd10s', 'patient_death_record_causes.icd10_code', '=', 'lib_icd10s.icd10_code')
            ->join('users', 'patient_death_record_causes.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_death_records.patient_id');
            })
            ->where('patient_death_record_causes.cause_code', 'UND')
            ->whereYear('date_of_death', $request->year)
            ->whereMonth('date_of_death', $request->month)
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_death_records.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->groupBy('patient_death_record_causes.icd10_code');
    }
}
