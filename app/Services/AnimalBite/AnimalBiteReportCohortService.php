<?php

namespace App\Services\AnimalBite;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use Illuminate\Support\Facades\DB;

class AnimalBiteReportCohortService
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

    public function get_ab_post_exp_prophylaxis($request)
    {
        return DB::table('patient_ab_exposures')
            ->selectRaw("
                        SUM(
                            CASE WHEN exposure_type_code IN('MINOR', 'NIBB') THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2',
                        SUM(
                            CASE WHEN exposure_type_code IN('CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC') THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat3',
                        SUM(
                            CASE WHEN exposure_type_code IN('NIBB', 'MINOR', 'CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC') THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2_and_cat3',
                        SUM(
                            CASE WHEN exposure_type_code IN('MINOR', 'NIBB')
                                AND rig_type_code IN('ERIG', 'HRIG') THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2_with_rig',
                        SUM(
                            CASE WHEN exposure_type_code IN('CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC')
                                AND rig_type_code IN('ERIG', 'HRIG') THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat3_with_rig',
                        SUM(
                            CASE WHEN exposure_type_code IN('NIBB', 'MINOR', 'CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC')
                                AND rig_type_code IN('ERIG', 'HRIG') THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2_and_cat3_with_rig',
                        SUM(
                            CASE WHEN exposure_type_code IN('MINOR', 'NIBB')
                                AND day0_date IS NOT NULL
                                AND day3_date IS NOT NULL
                                AND day7_date IS NOT NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2_complete',
                        SUM(
                            CASE WHEN exposure_type_code IN('CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC')
                                AND day0_date IS NOT NULL
                                AND day3_date IS NOT NULL
                                AND day7_date IS NOT NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat3_complete',
                        SUM(
                            CASE WHEN exposure_type_code IN('MINOR', 'NIBB', 'CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC')
                                AND day0_date IS NOT NULL
                                AND day3_date IS NOT NULL
                                AND day7_date IS NOT NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2_and_cat3_complete',
                        SUM(
                            CASE WHEN exposure_type_code IN('MINOR', 'NIBB')
                                OR day0_date IS NOT NULL
                                OR day3_date IS NOT NULL
                                OR day7_date IS NOT NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2_incomplete',
                        SUM(
                            CASE WHEN exposure_type_code IN('CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC')
                                OR day0_date IS NOT NULL
                                OR day3_date IS NOT NULL
                                OR day7_date IS NOT NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat3_incomplete',

                        SUM(
                            CASE WHEN exposure_type_code IN('MINOR', 'NIBB')
                                AND day0_date IS NOT NULL
                                OR day3_date IS NOT NULL
                                OR day7_date IS NOT NULL THEN
                                1
                            ELSE
                                0
                            END) +
                        SUM(
                            CASE WHEN exposure_type_code IN('CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC')
                                AND day0_date IS NOT NULL
                                OR day3_date IS NOT NULL
                                OR day7_date IS NOT NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2_and_cat3_incomplete',
                        SUM(
                            CASE WHEN exposure_type_code IN('MINOR', 'NIBB')
                                AND day0_date IS NULL
                                AND day3_date IS NULL
                                AND day7_date IS NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2_none',
                        SUM(
                            CASE WHEN exposure_type_code IN('CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC')
                                AND day0_date IS NULL
                                AND day3_date IS NULL
                                AND day7_date IS NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat3_none',
                        SUM(
                            CASE WHEN exposure_type_code IN('MINOR', 'NIBB', 'CONTAM', 'INGESTION', 'TRANS', 'BATS', 'UNPROC')
                                AND day0_date IS NULL
                                AND day3_date IS NULL
                                AND day7_date IS NULL THEN
                                1
                            ELSE
                                0
                            END) AS 'total_cat2_and_cat3_none'
                    ")
            ->join('patient_abs', 'patient_ab_exposures.patient_ab_id', '=', 'patient_abs.id')
            ->join('patient_ab_post_exposures', 'patient_ab_exposures.patient_ab_id', '=', 'patient_ab_post_exposures.patient_ab_id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_ab_exposures.patient_id');
            })
            ->whereNull('patient_ab_exposures.deleted_at')
            ->whereBetween(DB::raw('DATE(exposure_date)'), [$request->start_date, $request->end_date])
            ->where('patient_ab_exposures.facility_code', auth()->user()->facility_code)
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
