<?php

namespace App\Services\AnimalBite;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use Illuminate\Support\Facades\DB;

class AnimalBiteReportAnnualService
{
    public function get_catchment_barangays()
    {
        $result = DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code,
                        population
                    ')
            ->whereFacilityCode(auth()->user()->facility_code);

        return $result->pluck('barangay_code');
    }

    public function get_barangay_population()
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw('
                        barangay_code,
                        population
                    ')
            ->whereFacilityCode(auth()->user()->facility_code);
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

    public function get_ab_post_exp_prophylaxis($request)
    {
        return DB::table('patient_abs')
            ->selectRaw("
                        barangays.name,
                        settings_catchment_barangays.population,
                        SUM(
                            CASE WHEN patients.gender = 'M' THEN
                                1
                            ELSE
                                0
                            END) AS 'male',
                        SUM(
                            CASE WHEN patients.gender = 'F' THEN
                                1
                            ELSE
                                0
                            END) AS 'female',
                        SUM(
                            CASE WHEN gender IN('M', 'F') THEN
                                1
                            ELSE
                                0
                            END) AS 'male_female_total',
                        SUM(
                            CASE WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) < 15) THEN
                                1
                            ELSE
                                0
                            END) AS 'less_than_15',
                        SUM(
                            CASE WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) >= 15) THEN
                                1
                            ELSE
                                0
                            END) AS 'greater_than_15',
                        SUM(
                            CASE WHEN (TIMESTAMPDIFF(YEAR, birthdate, consult_date) >= 15)
                                OR(TIMESTAMPDIFF(YEAR, birthdate, consult_date) < 15) THEN
                                1
                            ELSE
                                0
                            END) AS 'less_than_and_greater_than_15',
                        SUM(
                            CASE WHEN animal_type_id = 1 THEN
                                1
                            ELSE
                                0
                            END) AS 'dog',
                        SUM(
                            CASE WHEN animal_type_id = 2 THEN
                                1
                            ELSE
                                0
                            END) AS 'cat',
                        SUM(
                            CASE WHEN animal_type_id = 3 THEN
                                1
                            ELSE
                                0
                            END) AS 'bat',
                        SUM(
                            CASE WHEN animal_type_id = 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'monkey',
                        SUM(
                            CASE WHEN animal_type_id = 5 THEN
                                1
                            ELSE
                                0
                            END) AS 'others',
                        SUM(
                            CASE WHEN exposure_type_code IN('CASUAL', 'EXPOSE', 'FEED', 'LICK') THEN
                                1
                            ELSE
                                0
                            END) AS 'category1',
                        SUM(
                            CASE WHEN exposure_type_code IN('MINOR', 'NIBB') THEN
                                1
                            ELSE
                                0
                            END) AS 'category2',
                        SUM(
                            CASE WHEN exposure_type_code IN('CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC') THEN
                                1
                            ELSE
                                0
                            END) AS 'category3',
                        SUM(
                            CASE WHEN exposure_type_code IN('CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC') THEN
                                1
                            ELSE
                                0
                            END) AS 'category3',
                        SUM(
                            CASE WHEN patient_ab_pre_exposures.day0_date IS NOT NULL
                                OR patient_ab_pre_exposures.day7_date IS NOT NULL
                                OR patient_ab_pre_exposures.day21_date IS NOT NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'PreP',
                        SUM(
                            CASE WHEN tandok_name IS NOT NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'tandok',
                        SUM(
                            CASE WHEN rig_type_code = 'HRIG' THEN
                                1
                            ELSE
                                0
                            END) AS 'hrig',
                        SUM(
                            CASE WHEN rig_type_code = 'ERIG' THEN
                                1
                            ELSE
                                0
                            END) AS 'erig'
                    ")
            ->join('patient_ab_exposures', 'patient_abs.id', '=', 'patient_ab_exposures.patient_ab_id')
            ->join('patient_ab_pre_exposures', 'patient_abs.patient_id', '=', 'patient_ab_pre_exposures.patient_id')
            ->leftJoin('patient_ab_post_exposures', 'patient_abs.id', '=', 'patient_ab_post_exposures.patient_ab_id')
            ->join('patients', 'patient_abs.patient_id', '=', 'patients.id')
            ->join('household_members', 'patient_ab_pre_exposures.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->join('settings_catchment_barangays', 'barangays.psgc_10_digit_code', '=', 'settings_catchment_barangays.barangay_code')
            ->whereBetween(DB::raw('DATE(day0_date)'), [$request->start_date, $request->end_date])
            ->where('patient_abs.facility_code', auth()->user()->facility_code)
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('household_folders.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities.psgc_10_digit_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('household_folders.barangay_code', explode(',', $request->code));
            })
            ->groupBy('barangays.name');
    }
}
