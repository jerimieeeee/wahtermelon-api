<?php

namespace App\Services\FamilyPlanning;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class FamilyPlanningReportService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
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
//            ->join('patients', 'household_members.patient_id', '=', 'patients.id');
//            ->groupBy('patient_id', 'municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }

    public function get_fp_report($request)
    {
        return DB::table('patient_fp_methods')
            ->selectRaw("
                       method_code,
                        SUM(
                            CASE WHEN client_code = 'CU'
                                AND(DATE_FORMAT(dropout_date, '%Y-%m') IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 10 AND 14
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) +
                        SUM(
                            CASE WHEN client_code = 'NA'
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 10 AND 14
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT( IF(? <= 2, ? - 1, ?), '-', LPAD( IF(? <= 2, ? + 10, ? - 2), 2, '0')) THEN
                                            1
                                        ELSE
                                            0
                                        END) +
                        SUM(
                            CASE WHEN client_code IN('CC', 'CM', 'RS')
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 10 AND 14
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT( IF(? = 1, ? - 1, ?), '-', LPAD( IF(? = 1, 12, ? - 1), 2, '0')) THEN
                                            1
                                        ELSE
                                            0
                        END) AS 'current_user_beginning_month_10_to_14',
                        SUM(
                            CASE WHEN client_code = 'CU'
                                AND(DATE_FORMAT(dropout_date, '%Y-%m') IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 15 AND 19
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) +
                        SUM(
                            CASE WHEN client_code = 'NA'
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 15 AND 19
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT( IF(? <= 2, ? - 1, ?), '-', LPAD( IF(? <= 2, ? + 10, ? - 2), 2, '0')) THEN
                                            1
                                        ELSE
                                            0
                                        END) +
                        SUM(
                            CASE WHEN client_code IN('CC', 'CM', 'RS')
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 15 AND 19
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT( IF(? = 1, ? - 1, ?), '-', LPAD( IF(? = 1, 12, ? - 1), 2, '0')) THEN
                                            1
                                        ELSE
                                            0
                        END) AS 'current_user_beginning_month_15_to_19',
                        SUM(
                            CASE WHEN client_code = 'CU'
                                AND(DATE_FORMAT(dropout_date, '%Y-%m') IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 20 AND 49
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) +
                        SUM(
                            CASE WHEN client_code = 'NA'
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 20 AND 49
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT( IF(? <= 2, ? - 1, ?), '-', LPAD( IF(? <= 2, ? + 10, ? - 2), 2, '0')) THEN
                                            1
                                        ELSE
                                            0
                                        END) +
                        SUM(
                            CASE WHEN client_code IN('CC', 'CM', 'RS')
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 20 AND 49
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT( IF(? = 1, ? - 1, ?), '-', LPAD( IF(? = 1, 12, ? - 1), 2, '0')) THEN
                                            1
                                        ELSE
                                            0
                        END) AS 'current_user_beginning_month_20_to_49',
                        SUM(
                            CASE WHEN client_code = 'NA'
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT( IF(? = 1, ? - 1, ?), '-', LPAD( IF(? = 1, 12, ? - 1), 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 10 AND 14
                                AND IF(? = 1, MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ? - 1, MONTH(enrollment_date) = ? - 1 AND YEAR(enrollment_date) = ?)
                                THEN 1
                                ELSE 0
                            END) AS 'new_acceptor_previous_month_10_to_14',
                        SUM(
                            CASE WHEN client_code = 'NA'
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT( IF(? = 1, ? - 1, ?), '-', LPAD( IF(? = 1, 12, ? - 1), 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 15 AND 19
                                AND IF(? = 1, MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ? - 1, MONTH(enrollment_date) = ? - 1 AND YEAR(enrollment_date) = ?)
                                THEN 1
                                ELSE 0
                            END) AS 'new_acceptor_previous_month_15_to_19',
                        SUM(
                            CASE WHEN client_code = 'NA'
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT( IF(? = 1, ? - 1, ?), '-', LPAD( IF(? = 1, 12, ? - 1), 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 20 AND 49
                                AND IF(? = 1, MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ? - 1, MONTH(enrollment_date) = ? - 1 AND YEAR(enrollment_date) = ?)
                                THEN 1
                                ELSE 0
                            END) AS 'new_acceptor_previous_month_20_to_49',
                        SUM(
                            CASE WHEN client_code IN('CC', 'CM', 'RS')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 10 AND 14
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'other_acceptor_present_month_10_to_14',
                        SUM(
                            CASE WHEN client_code IN('CC', 'CM', 'RS')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 15 AND 19
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'other_acceptor_present_month_15_to_19',
                        SUM(
                            CASE WHEN client_code IN('CC', 'CM', 'RS')
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 20 AND 49
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'other_acceptor_present_month_20_to_49',
                        SUM(
                            CASE WHEN dropout_date IS NOT NULL
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0'))
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <> DATE_FORMAT(dropout_date, '%Y-%m')  -- Exclude same-month dropouts
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 10 AND 14
                                AND DATE_FORMAT(dropout_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'dropout_present_month_10_to_14',
                        SUM(
                            CASE WHEN dropout_date IS NOT NULL
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0'))
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <> DATE_FORMAT(dropout_date, '%Y-%m')  -- Exclude same-month dropouts
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 15 AND 19
                                AND DATE_FORMAT(dropout_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'dropout_present_month_15_to_19',
                        SUM(
                            CASE WHEN dropout_date IS NOT NULL
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0'))
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') <> DATE_FORMAT(dropout_date, '%Y-%m')  -- Exclude same-month dropouts
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) BETWEEN 20 AND 49
                                AND DATE_FORMAT(dropout_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'dropout_present_month_20_to_49',
                        SUM(
                            CASE WHEN client_code = 'NA'
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, enrollment_date) BETWEEN 10 AND 14
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'new_acceptor_present_month_10_to_14',
                        SUM(
                            CASE WHEN client_code = 'NA'
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, enrollment_date) BETWEEN 15 AND 19
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'new_acceptor_present_month_15_to_19',
                        SUM(
                            CASE WHEN client_code = 'NA'
                                AND(dropout_date IS NULL
                                    OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                                AND TIMESTAMPDIFF(YEAR, patients.birthdate, enrollment_date) BETWEEN 20 AND 49
                                AND DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0')) THEN
                                1
                            ELSE
                                0
                            END) AS 'new_acceptor_present_month_20_to_49'
                    ",
                [
                //BINDINGS FOR Current User (Beginning Month) 10 to 14
                $request->year, $request->month,
                $request->year, $request->month,
                $request->year, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month, $request->month,
                $request->year, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month,

                //BINDINGS FOR Current User (Beginning Month) 15 to 19
                $request->year, $request->month,
                $request->year, $request->month,
                $request->year, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month, $request->month,
                $request->year, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month,

                //BINDINGS FOR Current User (Beginning Month) 20 to 49
                $request->year, $request->month,
                $request->year, $request->month,
                $request->year, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month, $request->month,
                $request->year, $request->month,
                $request->month, $request->year, $request->year, $request->month, $request->month,

                //BINDINGS FOR New Acceptor (Previous Month) 10 to 14
                $request->month, $request->year, $request->year, $request->month, $request->month,
                $request->month, $request->year, $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Previous Month) 15 to 19
                $request->month, $request->year, $request->year, $request->month, $request->month,
                $request->month, $request->year, $request->month, $request->year,

                //BINDINGS FOR New Acceptor (Previous Month) 20 to 49
                $request->month, $request->year, $request->year, $request->month, $request->month,
                $request->month, $request->year, $request->month, $request->year,

                //BINDINGS FOR Other Acceptor (Present Month) 10 to 14
                $request->year, $request->month,

                //BINDINGS FOR Other Acceptor (Present Month) 15 to 19
                $request->year, $request->month,

                //BINDINGS FOR Other Acceptor (Present Month) 20 to 49
                $request->year, $request->month,

                //BINDINGS FOR Dropout (Present Month) 10 to 14
                $request->year, $request->month,
                $request->year, $request->month,

                //BINDINGS FOR Dropout (Present Month) 15 to 19
                $request->year, $request->month,
                $request->year, $request->month,

                //BINDINGS FOR Dropout (Present Month) 20 to 49
                $request->year, $request->month,
                $request->year, $request->month,

                //BINDINGS FOR New Acceptor (Present Month) 10 to 14
                $request->year, $request->month,
                $request->year, $request->month,

                //BINDINGS FOR New Acceptor (Present Month) 15 to 19
                $request->year, $request->month,
                $request->year, $request->month,

                //BINDINGS FOR New Acceptor (Present Month) 20 to 49
                $request->year, $request->month,
                $request->year, $request->month,

            ])
        ->join('patients', 'patient_fp_methods.patient_id', '=', 'patients.id')
        ->join('users', 'patient_fp_methods.user_id', '=', 'users.id')
        ->whereNull('patient_fp_methods.deleted_at')
        ->tap(function ($query) use ($request) {
            $this->categoryFilterService->applyCategoryFilter($query,   $request, 'patient_fp_methods.facility_code', 'patient_fp_methods.patient_id');
        })
        ->groupBy('method_code');
    }

    public function get_fp_report_all($request)
    {
        return DB::table(function ($query) use($request) {
            $query->selectRaw("
                        lib_fp_methods.code,
                        CAST(IFNULL(current_user_beginning_month_10_to_14, 0) AS UNSIGNED) AS current_user_beginning_month_10_to_14,
                        CAST(IFNULL(current_user_beginning_month_15_to_19, 0) AS UNSIGNED) AS current_user_beginning_month_15_to_19,
                        CAST(IFNULL(current_user_beginning_month_20_to_49, 0) AS UNSIGNED) AS current_user_beginning_month_20_to_49,
                        CAST(IFNULL(new_acceptor_previous_month_10_to_14, 0) AS UNSIGNED) AS new_acceptor_previous_month_10_to_14,
                        CAST(IFNULL(new_acceptor_previous_month_15_to_19, 0) AS UNSIGNED) AS new_acceptor_previous_month_15_to_19,
                        CAST(IFNULL(new_acceptor_previous_month_20_to_49, 0) AS UNSIGNED) AS new_acceptor_previous_month_20_to_49,
                        CAST(IFNULL(other_acceptor_present_month_10_to_14, 0) AS UNSIGNED) AS other_acceptor_present_month_10_to_14,
                        CAST(IFNULL(other_acceptor_present_month_15_to_19, 0) AS UNSIGNED) AS other_acceptor_present_month_15_to_19,
                        CAST(IFNULL(other_acceptor_present_month_20_to_49, 0) AS UNSIGNED) AS other_acceptor_present_month_20_to_49,
                        CAST(IFNULL(dropout_present_month_10_to_14, 0) AS UNSIGNED) AS dropout_present_month_10_to_14,
                        CAST(IFNULL(dropout_present_month_15_to_19, 0) AS UNSIGNED) AS dropout_present_month_15_to_19,
                        CAST(IFNULL(dropout_present_month_20_to_49, 0) AS UNSIGNED) AS dropout_present_month_20_to_49,
                        CAST(IFNULL(new_acceptor_present_month_10_to_14, 0) AS UNSIGNED) AS new_acceptor_present_month_10_to_14,
                        CAST(IFNULL(new_acceptor_present_month_15_to_19, 0) AS UNSIGNED) AS new_acceptor_present_month_15_to_19,
                        CAST(IFNULL(new_acceptor_present_month_20_to_49, 0) AS UNSIGNED) AS new_acceptor_present_month_20_to_49
                    ")
            ->from('lib_fp_methods')
            ->leftJoinSub($this->get_fp_report($request), 'fp_report', function ($join) {
                $join->on('fp_report.method_code', '=', 'lib_fp_methods.code');
            });
        });
    }
}
