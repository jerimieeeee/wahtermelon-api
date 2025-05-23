<?php

namespace App\Services\Masterlist;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class MasterlistReportService
{
    protected $categoryFilterService;

    public function __construct(CategoryFilterService $categoryFilterService)
    {
        $this->categoryFilterService = $categoryFilterService;
    }

    public function get_maternal_care_master_list($request)
    {
        return DB::table('patient_mc_pre_registrations')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ', ', patients.middle_name) AS name,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, pre_registration_date) AS age,
                        CONCAT(household_folders.address, ',', ' ', barangays.name, ',', ' ', municipalities.name) AS address,
                        patients.birthdate AS birthdate,
                        DATE_FORMAT(patient_mc_pre_registrations.pre_registration_date, '%Y-%m-%d') AS date_of_registration,
                        lmp_date,
                        edc_date,
                        DATE_FORMAT(patient_mc_post_registrations.post_registration_date, '%Y-%m-%d') AS delivery_date
                    ")
            ->join('patient_mc', 'patient_mc_pre_registrations.patient_mc_id', '=', 'patient_mc.id')
            ->leftJoin('patient_mc_post_registrations', 'patient_mc.id', '=', 'patient_mc_post_registrations.patient_mc_id')
            ->join('patients', 'patient_mc.patient_id', '=', 'patients.id')
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('users', 'patient_mc.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_mc.facility_code', 'patient_mc.patient_id');
            })
            ->whereBetween('pre_registration_date', [
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59'    // End of the day
            ])
            ->orderBy('name', 'ASC');
    }

    public function get_fp_method_master_list($request)
    {
        return DB::table('patient_fp')
            ->selectRaw("
            CONCAT(patients.last_name, ', ', patients.first_name, ', ', patients.middle_name) AS name,
            TIMESTAMPDIFF(YEAR, patients.birthdate, enrollment_date) AS age,
            patients.gender,
            CONCAT(household_folders.address, ', ', barangays.name, ', ', municipalities.name) AS address,
            patients.birthdate AS birthdate,
            DATE_FORMAT(patient_fp_methods.enrollment_date, '%Y-%m-%d') AS date_of_registration,
            CASE
                WHEN client_code = 'NA'
                    AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                    AND DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0'))
                    THEN 'new_acceptor_present_month'
                WHEN client_code IN ('CC', 'CM', 'RS')
                    AND DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0'))
                    THEN 'other_acceptor_present_month'
                WHEN client_code = 'CU'
                    AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                    AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0'))
                    THEN 'current_user_beginning_month'
                WHEN client_code = 'NA'
                    AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                    AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0'))
                    THEN 'current_user_beginning_month'
                WHEN client_code IN ('CC', 'CM', 'RS')
                    AND (dropout_date IS NULL OR DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0')))
                    AND DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0'))
                    THEN 'current_user_beginning_month'
                WHEN dropout_date IS NOT NULL
                    AND DATE_FORMAT(dropout_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0'))
                    THEN 'dropout_present_month_10_to_14'
                ELSE NULL
            END AS client_type,
            enrollment_date,
            lib_fp_methods.desc AS method,
            DATE_FORMAT(patient_fp_methods.dropout_date, '%Y-%m-%d') AS dropout_date,
            lib_fp_dropout_reasons.desc AS dropout_reasons,
            dropout_remarks AS remarks
        ", [
                // New Acceptor Present Month
                $request->year, $request->month,
                $request->year, $request->month,

                // Other Acceptor Present Month
                $request->year, $request->month,

                // Current User Beginning Month
                $request->year, $request->month,
                $request->year, $request->month,

                // Current User Beginning Month (Alternative)
                $request->year, $request->month,
                $request->year, $request->month,

                // Current User Beginning Month (Alternative)
                $request->year, $request->month,
                $request->year, $request->month,

                // Dropout Present Month
                $request->year, $request->month,
            ])
            ->join('patient_fp_methods', 'patient_fp.id', '=', 'patient_fp_methods.patient_fp_id')
            ->join('patients', 'patient_fp.patient_id', '=', 'patients.id')
            ->join('lib_fp_client_types', 'patient_fp_methods.client_code', '=', 'lib_fp_client_types.code')
            ->join('lib_fp_methods', 'patient_fp_methods.method_code', '=', 'lib_fp_methods.code')
            ->leftJoin('lib_fp_dropout_reasons', 'patient_fp_methods.dropout_reason_code', '=', 'lib_fp_dropout_reasons.code')
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('users', 'patient_fp.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_fp.facility_code', 'patient_fp.patient_id');
            })
            ->havingRaw('client_type IS NOT NULL')
            ->orderBy('name', 'ASC');
    }


    public function get_bloodtype_master_list($request)
    {
        return DB::table('patients')
            ->selectRaw("
            CONCAT(patients.last_name, ', ', patients.first_name, ', ', patients.middle_name) AS name,
            patients.gender,
            CONCAT(household_folders.address, ', ', barangays.name, ', ', municipalities.name) AS address,
            patients.birthdate AS birthdate,
            blood_type_code
        ")
        ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
        ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
        ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
        ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
        ->join('users', 'patients.user_id', '=', 'users.id')
        ->tap(function ($query) use ($request) {
            $this->categoryFilterService->applyCategoryFilter($query, $request, 'patients.facility_code', 'patients.id');
        })
        ->whereNotIn('blood_type_code', ['', 'NA']) // Exclude empty and 'NA' values
        ->when(isset($request->blood_type_code), function ($q) use ($request) {
            $q->where('blood_type_code', '=', $request->blood_type_code);
        })
        ->orderBy('blood_type_code', 'ASC');
    }

    public function get_senior_masterlist($request)
    {
        return DB::table('patients')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ', ', patients.middle_name) AS name,
                        patients.gender,
                        CONCAT(household_folders.address, ',', ' ', barangays.name, ',', ' ', municipalities.name) AS address,
                        patients.birthdate AS birthdate,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, NOW()) AS age
                ")
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patients.facility_code', 'patients.id');
            })
            ->when($request->gender === 'M', function ($q) use ($request) {
                $q->where('gender', '=', 'M');
            })
            ->when($request->gender === 'F', function ($q) use ($request) {
                $q->where('gender', '=', 'F');
            })
            ->when($request->gender === 'ALL', function ($q) use ($request) {
                $q->whereIn('gender', ['M', 'F']);
            })
            ->havingRaw('age >= 60')
            ->orderBy('blood_type_code', 'ASC');
    }
}
