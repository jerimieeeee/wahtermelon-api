<?php

namespace App\Services\Dental;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use Illuminate\Support\Facades\DB;

class DentalReportService
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

    public function get_dental_report($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND orally_fit_flag = 1
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 12 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_12_59_months_orally_fit',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND orally_fit_flag = 1
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 12 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_12_59_months_orally_fit',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                            	AND service_id IN(7, 6, 1)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 8 THEN
                                1
                            ELSE
                                0
                            END) + SUM(
                            CASE WHEN patients.gender = 'M'
                            	AND service_id IN(7, 6, 1)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 9 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_0_11_months_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id IN(7, 17, 15, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_1_4_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id IN(7, 17, 15, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_5_9_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id IN(7, 4)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_10_19_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id IN(7, 4)
                                AND(TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59) THEN
                                1
                            ELSE
                                0
                            END) AS 'male_20_59_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id IN(7, 4)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'male_60_above_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'M'
                                AND service_id IN(1, 6, 7)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 8 THEN
                                1
                            ELSE
                                0
                            END) + SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id IN(1, 6, 7, 17)
                                AND TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 9 AND 11 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_0_11_months_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id IN(7, 17, 15, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_1_4_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id IN(7, 15, 8)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_5_9_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id IN(7, 4)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_10_19_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id IN(7, 4)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_20_59_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id IN(7, 4)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60 THEN
                                1
                            ELSE
                                0
                            END) AS 'female_60_above_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id IN(7, 4)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14 THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_10_14_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id IN(7, 4)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19 THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_15_19_years_bohc',
                        SUM(
                            CASE WHEN patients.gender = 'F'
                                AND service_id IN(7, 4)
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49 THEN
                                1
                            ELSE
                                0
                            END) AS 'pregnant_women_20_49_years_bohc'
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('dental_oral_health_conditions', 'consults.id', '=', 'dental_oral_health_conditions.consult_id')
            ->leftJoin('dental_tooth_services', 'consults.id', '=', 'dental_tooth_services.consult_id')
            ->leftJoin('dental_services', 'consults.id', '=', 'dental_services.consult_id')
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
//            ->whereYear('consult_date', $request->year)
//            ->whereMonth('consult_date', $request->month)
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

    public function get_dmft($request, $gender)
    {
        return DB::table('consults')
            ->selectRaw("
                        COUNT(DISTINCT patients.id) AS dmft
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
//            ->leftJoin('dental_oral_health_conditions', 'consults.id', '=', 'dental_oral_health_conditions.consult_id')
//            ->leftJoin('dental_tooth_services', 'consults.id', '=', 'dental_tooth_services.consult_id')
//            ->leftJoin('dental_services', 'consults.id', '=', 'dental_services.consult_id')
            ->leftJoin('dental_tooth_conditions', 'consults.id', '=', 'dental_tooth_conditions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'consults.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('consults.facility_code', auth()->user()->facility_code);
            })
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('consult_date', $request->year)
//            ->whereMonth('consult_date', $request->month)
            ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consults.consult_date) >= 5")
            ->where('patients.gender', $gender)
            ->whereIn('dental_tooth_conditions.tooth_number',
                [
                    '11', '12', '13', '14', '15', '16', '17',
                    '18', '21', '22', '23', '24', '25', '26',
                    '27', '28', '41', '42', '43', '44', '45',
                    '46', '47', '48', '31', '32', '33', '34',
                    '35', '36', '37', '38'
                ]
            )
            ->whereIn('dental_tooth_conditions.tooth_number', ['D', 'M', 'F'])
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
