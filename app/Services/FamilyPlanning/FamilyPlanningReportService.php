<?php

namespace App\Services\FamilyPlanning;

use Illuminate\Support\Facades\DB;

class FamilyPlanningReportService
{
    public function get_projected_population()
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code,
                        name AS barangay_name,
                        year,
                        settings_catchment_barangays.population,
                        (SELECT SUM(population) FROM settings_catchment_barangays) AS total_population
                    ')
            ->leftJoin('barangays', 'barangays.psgc_10_digit_code', '=', 'settings_catchment_barangays.barangay_code')
            ->whereFacilityCode(auth()->user()->facility_code)
            ->groupBy('facility_code', 'barangay_code', 'year', 'population');
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
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->groupBy('patient_id', 'municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }

    public function get_fp_report($request)
    {
        return DB::table('patient_fp_methods')
            ->selectRaw("
                        method_code,
                        SUM(
                            CASE WHEN client_code = 'CU'
                                AND (DATE_FORMAT(dropout_date, '%Y-%m') IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND dropout_reason_code IS NULL
                                AND TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) + SUM(
                            CASE WHEN client_code = 'NA'
                                AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') <= CONCAT(IF(? <= 2, ?-2, ?), '-', LPAD(IF(? <= 2, ?+10, ?-2), 2, '0')))
                                AND dropout_reason_code IS NULL
                                AND TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(IF(? <= 2, ?-1, ?), '-', LPAD(IF(? <= 2, ?+10, ?-2), 2, '0')) THEN
                                        1
                                    ELSE
                                        0
                                    END) + SUM(
                            CASE WHEN client_code IN('CC', 'CM', 'RS')
                                AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') <= CONCAT(IF(? = 1, ?-1, ?), '-', LPAD(IF(? = 1, 12, ?-1), 2, '0')))
                                AND dropout_reason_code IS NULL
                                AND TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(IF(? = 1, ?-1, ?), '-', LPAD(IF(? = 1, 12, ?-1), 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'current_user_beginning_month_10_to_14',
                        SUM(
                            CASE WHEN client_code = 'CU'
                                AND (DATE_FORMAT(dropout_date, '%Y-%m') IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND dropout_reason_code IS NULL
                                AND TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) + SUM(
                            CASE WHEN client_code = 'NA'
                                AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') <= CONCAT(IF(? <= 2, ?-2, ?), '-', LPAD(IF(? <= 2, ?+10, ?-2), 2, '0')))
                                AND dropout_reason_code IS NULL
                                AND TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(IF(? <= 2, ?-1, ?), '-', LPAD(IF(? <= 2, ?+10, ?-2), 2, '0')) THEN
                                        1
                                    ELSE
                                        0
                                    END) + SUM(
                            CASE WHEN client_code IN('CC', 'CM', 'RS')
                                AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') <= CONCAT(IF(? = 1, ?-1, ?), '-', LPAD(IF(? = 1, 12, ?-1), 2, '0')))
                                AND dropout_reason_code IS NULL
                                AND TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(IF(? = 1, ?-1, ?), '-', LPAD(IF(? = 1, 12, ?-1), 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'current_user_beginning_month_15_to_19',
                        SUM(
                            CASE WHEN client_code = 'CU'
                                AND (DATE_FORMAT(dropout_date, '%Y-%m') IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND dropout_reason_code IS NULL
                                AND TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) + SUM(
                            CASE WHEN client_code = 'NA'
                                AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') <= CONCAT(IF(? <= 2, ?-2, ?), '-', LPAD(IF(? <= 2, ?+10, ?-2), 2, '0')))
                                AND dropout_reason_code IS NULL
                                AND TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(IF(? <= 2, ?-1, ?), '-', LPAD(IF(? <= 2, ?+10, ?-2), 2, '0')) THEN
                                        1
                                    ELSE
                                        0
                                    END) + SUM(
                            CASE WHEN client_code IN('CC', 'CM', 'RS')
                                AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') <= CONCAT(IF(? = 1, ?-1, ?), '-', LPAD(IF(? = 1, 12, ?-1), 2, '0')))
                                AND dropout_reason_code IS NULL
                                AND TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(IF(? = 1, ?-1, ?), '-', LPAD(IF(? = 1, 12, ?-1), 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'current_user_beginning_month_20_to_49',
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14 AND
                                IF(? = 1, MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ?-1, MONTH(enrollment_date) = ?-1 AND YEAR(enrollment_date) = ?)
                            THEN 1
                            ELSE 0
                            END) AS 'new_acceptor_previous_month_10_to_14',
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19 AND
                                IF(? = 1, MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ?-1, MONTH(enrollment_date) = ?-1 AND YEAR(enrollment_date) = ?)
                                THEN 1
                                ELSE 0
                            END) AS 'new_acceptor_previous_month_15_to_19',
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49 AND
                                IF(? = 1, MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ?-1, MONTH(enrollment_date) = ?-1 AND YEAR(enrollment_date) = ?)
                                THEN 1
                                ELSE 0
                            END) AS 'new_acceptor_previous_month_20_to_49',
                        SUM(CASE
                            WHEN
                                client_code IN('CC', 'CM', 'RS') AND
                            TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14 AND
                            MONTH(enrollment_date) = ? AND
                            YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'other_acceptor_present_month_10_to_14',
                        SUM(CASE
                                WHEN
                                    client_code IN('CC', 'CM', 'RS') AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'other_acceptor_present_month_15_to_19',
                        SUM(CASE
                            WHEN
                                client_code IN('CC', 'CM', 'RS') AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'other_acceptor_present_month_20_to_49',
                          	SUM(CASE
                                WHEN
                                    dropout_date IS NOT NULL AND
                                    dropout_reason_code IS NOT NULL AND
                                    TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14 AND
                                    MONTH(dropout_date) = ? AND
                                    YEAR(dropout_date) = ?
                                THEN 1
                                ELSE 0
                              END) AS 'dropout_present_month_10_to_14',
                        SUM(CASE
                            WHEN
                                dropout_date IS NOT NULL AND
                                dropout_reason_code IS NOT NULL AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19 AND
                                MONTH(dropout_date) = ? AND
                                YEAR(dropout_date) = ?
                            THEN 1
                            ELSE 0
                          END) AS 'dropout_present_month_15_to_19',
                        SUM(CASE
                            WHEN
                                dropout_date IS NOT NULL AND
                                dropout_reason_code IS NOT NULL AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49 AND
                                MONTH(dropout_date) = ? AND
                                YEAR(dropout_date) = ?
                            THEN 1
                            ELSE 0
                          END) AS 'dropout_present_month_20_to_49',
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 10 AND 14 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'new_acceptor_present_month_10_to_14',
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 15 AND 19 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'new_acceptor_present_month_15_to_19',
                        SUM(CASE
                            WHEN
                                client_code = 'NA' AND
                                TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) BETWEEN 20 AND 49 AND
                                MONTH(enrollment_date) = ? AND
                                YEAR(enrollment_date) = ?
                            THEN 1
                            ELSE 0
                        END) AS 'new_acceptor_present_month_20_to_49'
                    ",
                [
                //BINDINGS FOR Current User (Beginning Month) 10 to 14
                $request->year, $request->month,
                $request->year, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month,

                //BINDINGS FOR Current User (Beginning Month) 15 to 19
                $request->year, $request->month,
                $request->year, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month,

                //BINDINGS FOR Current User (Beginning Month) 20 to 49
                $request->year, $request->month,
                $request->year, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month,

                //BINDINGS FOR New Acceptor (Previous Month) 10 to 14
                $request->month, $request->year, $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Previous Month) 15 to 19
                $request->month, $request->year, $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Previous Month) 20 to 49
                $request->month, $request->year, $request->month, $request->year,

                //BINDINGS FOR Other Acceptor (Present Month) 10 to 14
                $request->month, $request->year,

                //BINDINGS FOR Other Acceptor (Present Month) 15 to 19
                $request->month, $request->year,

                //BINDINGS FOR Other Acceptor (Present Month) 20 to 49
                $request->month, $request->year,

                //BINDINGS FOR Dropout (Present Month) 10 to 14
                $request->month, $request->year,

                //BINDINGS FOR Dropout (Present Month) 15 to 19
                $request->month, $request->year,

                //BINDINGS FOR Dropout (Present Month) 20 to 49
                $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Present Month) 10 to 14
                $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Present Month) 15 to 19
                $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Present Month) 20 to 49
                $request->month, $request->year
            ])
        ->join('patients', 'patient_fp_methods.patient_id', '=', 'patients.id')
        ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
            $join->on('municipalities_brgy.patient_id', '=', 'patient_fp_methods.patient_id');
        })
        ->when($request->category == 'all', function ($q) {
            $q->where('patient_fp_methods.facility_code', auth()->user()->facility_code);
        })
        ->when($request->category == 'facility', function ($q) {
            $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
        })
        ->when($request->category == 'municipality', function ($q) use ($request) {
            $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
        })
        ->when($request->category == 'barangay', function ($q) use ($request) {
            $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
        })
        ->where('method_code', '!=', 'NA')
        ->groupBy('method_code');
    }

    public function get_fp_report_all($request)
    {
        return DB::table(function ($query) use($request) {
            $query->selectRaw("
                        code,
                        method_code,
                        CAST(current_user_beginning_month_10_to_14 AS UNSIGNED) AS current_user_beginning_month_10_to_14,
                        CAST(current_user_beginning_month_15_to_19 AS UNSIGNED) AS current_user_beginning_month_15_to_19,
                        CAST(current_user_beginning_month_20_to_49 AS UNSIGNED) AS current_user_beginning_month_20_to_49,
                        CAST(new_acceptor_previous_month_10_to_14 AS UNSIGNED) AS new_acceptor_previous_month_10_to_14,
                        CAST(new_acceptor_previous_month_15_to_19 AS UNSIGNED) AS new_acceptor_previous_month_15_to_19,
                        CAST(new_acceptor_previous_month_20_to_49 AS UNSIGNED) AS new_acceptor_previous_month_20_to_49,
                        CAST(other_acceptor_present_month_10_to_14 AS UNSIGNED) AS other_acceptor_present_month_10_to_14,
                        CAST(other_acceptor_present_month_15_to_19 AS UNSIGNED) AS other_acceptor_present_month_15_to_19,
                        CAST(other_acceptor_present_month_20_to_49 AS UNSIGNED) AS other_acceptor_present_month_20_to_49,
                        CAST(dropout_present_month_10_to_14 AS UNSIGNED) AS dropout_present_month_10_to_14,
                        CAST(dropout_present_month_15_to_19 AS UNSIGNED) AS dropout_present_month_15_to_19,
                        CAST(dropout_present_month_20_to_49 AS UNSIGNED) AS dropout_present_month_20_to_49,
                        CAST(new_acceptor_present_month_10_to_14 AS UNSIGNED) AS new_acceptor_present_month_10_to_14,
                        CAST(new_acceptor_present_month_15_to_19 AS UNSIGNED) AS new_acceptor_present_month_15_to_19,
                        CAST(new_acceptor_present_month_20_to_49 AS UNSIGNED) AS new_acceptor_present_month_20_to_49
                    ")
            ->from('lib_fp_methods')
            ->leftJoinSub($this->get_fp_report($request), 'fp_report', function ($join) {
                $join->on('fp_report.method_code', '=', 'lib_fp_methods.code');
            });
        });
    }
}
