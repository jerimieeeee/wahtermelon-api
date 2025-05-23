<?php

namespace App\Services\Household;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class HouseholdProfilingReportService
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

    public function get_patient_philhealth()
    {
        return DB::table('patients')
            ->selectRaw('
                        patients.id AS philhealth_patient_id,
                        membership_category_id
                    ')
            ->leftJoin('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id');
    }

    public function get_household_profiling_summary($request, $type)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($type == '4ps', function ($q) use ($request) {
                $q->whereNotNull('cct_id');
            })
            ->when($type == 'non-4ps', function ($q) use ($request) {
                $q->whereNull('cct_id');
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->groupBy('household_folders.id')
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_summary_family($request, $type)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
	                    SUM(number_of_families) AS total_number_of_families
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($type == '4ps', function ($q) use ($request) {
                $q->whereNotNull('cct_id');
            })
            ->when($type == 'non-4ps', function ($q) use ($request) {
                $q->whereNull('cct_id');
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_water_source($request, $type, $water_type)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id,
                        number_of_families,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($type == '4ps', function ($q) use ($request) {
                $q->whereNotNull('cct_id');
            })
            ->when($type == 'non-4ps', function ($q) use ($request) {
                $q->whereNull('cct_id');
            })
            ->when($water_type == 1, function ($q) use ($request, $water_type) {
                $q->where('water_type_code', $water_type);
            })
            ->when($water_type == 2, function ($q) use ($request, $water_type) {
                $q->where('water_type_code', $water_type);
            })
            ->when($water_type == 3, function ($q) use ($request, $water_type) {
                $q->where('water_type_code', $water_type);
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->groupBy('household_folders.id')
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_toilet_facilities($request, $type, $toilet_code)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id,
                        number_of_families,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($type == '4ps', function ($q) use ($request) {
                $q->whereNotNull('cct_id');
            })
            ->when($type == 'non-4ps', function ($q) use ($request) {
                $q->whereNull('cct_id');
            })
            ->when($toilet_code == 1, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 2, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 3, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 5, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 6, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 7, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->when($toilet_code == 8, function ($q) use ($request, $toilet_code) {
                $q->where('toilet_facility_code', $toilet_code);
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->groupBy('household_folders.id')
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_philhealth($request, $type)
    {
        $direct =
            "1,2,3,
            4,5,6,
            7,8,9,
            10,11,12,
            13,14,15,
            16,17,24";

        $indirect =
            "18,19,20,
            21,22,23";

        return DB::table('household_environmentals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
            ->joinSub($this->get_patient_philhealth(), 'patient_philhealth', function ($join) {
                $join->on('patient_philhealth.philhealth_patient_id', '=', 'patients.id');
            })
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($type == 'direct', function ($q) use ($request, $direct) {
                $q->whereIn('membership_category_id', explode(',', $direct));
            })
            ->when($type == 'indirect', function ($q) use ($request, $indirect) {
                $q->whereIn('membership_category_id', explode(',', $indirect));
            })
            ->when($type == 'unknown', function ($q) use ($request) {
                $q->whereNull('patient_philhealth.membership_category_id');
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_sex($request, $gender)
    {
        $all_gender = "M,F";

        return DB::table('household_environmentals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($gender == 'M', function ($q) use ($request, $gender) {
                $q->whereGender($gender);
            })
            ->when($gender == 'F', function ($q) use ($request, $gender) {
                $q->whereGender($gender);
            })
            ->when($gender == 'all', function ($q) use ($request, $all_gender) {
                $q->whereIn('gender', $all_gender);
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_ethnicity($request, $ethnicity)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($ethnicity == 'indegenous', function ($q) use ($request) {
                $q->where('patients.indegenous_flag', 1);
            })
            ->when($ethnicity == 'non-indegenous', function ($q) use ($request) {
                $q->where('patients.indegenous_flag', 0);
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_education($request, $type, $education)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($education == '1', function ($q) use ($request) {
                $q->where('patients.education_code', 1);
            })
            ->when($education == '2', function ($q) use ($request) {
                $q->where('patients.education_code', 2);
            })
            ->when($education == '3', function ($q) use ($request) {
                $q->where('patients.education_code', 3);
            })
            ->when($education == '4', function ($q) use ($request) {
                $q->where('patients.education_code', 4);
            })
            ->when($education == '6', function ($q) use ($request) {
                $q->where('patients.education_code', 6);
            })
            ->when($education == '7', function ($q) use ($request) {
                $q->where('patients.education_code', 7);
            })
            ->when($education == '9', function ($q) use ($request) {
                $q->where('patients.education_code', 9);
            })
            ->when($education == '10', function ($q) use ($request) {
                $q->where('patients.education_code', 10);
            })
            ->when($education == '11', function ($q) use ($request) {
                $q->where('patients.education_code', 11);
            })
            ->when($education == '12', function ($q) use ($request) {
                $q->where('patients.education_code', 12);
            })
            ->when($education == '13', function ($q) use ($request) {
                $q->where('patients.education_code', 13);
            })
            ->when($education == '14', function ($q) use ($request) {
                $q->where('patients.education_code', 14);
            })
            ->when($education == '15', function ($q) use ($request) {
                $q->where('patients.education_code', 15);
            })
            ->when($education == '16', function ($q) use ($request) {
                $q->where('patients.education_code', 16);
            })
            ->when($education == '17', function ($q) use ($request) {
                $q->where('patients.education_code', 17);
            })
            ->when($type == '4ps', function ($q) use ($request) {
                $q->whereNotNull('cct_id');
            })
            ->when($type == 'non-4ps', function ($q) use ($request) {
                $q->whereNull('cct_id');
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_civil_status($request, $type)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($type == 'single', function ($q) use ($request) {
                $q->where('patients.civil_status_code', 'SNGL');
            })
            ->when($type == 'married', function ($q) use ($request, ) {
                $q->where('patients.civil_status_code', 'MRRD');
            })
//            ->when($type == 'live-in', function ($q) use ($request) {
//                $q->where('patients.civil_status_code', 'CHBTN');
//            })
            ->when($type == 'widow', function ($q) use ($request) {
                $q->where('patients.civil_status_code', 'WDWD');
            })
            ->when($type == 'separated', function ($q) use ($request) {
                $q->where('patients.civil_status_code', 'SPRTD');
            })
            ->when($type == 'cohabit', function ($q) use ($request) {
                $q->where('patients.civil_status_code', 'CHBTN');
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_religion($request, $type)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($type == 'roman-catholic', function ($q) use ($request) {
                $q->where('patients.religion_code', 'RMNCATHO');
            })
            ->when($type == 'christian', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'XTIAN');
            })
            ->when($type == 'inc', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'IGNIK');
            })
            ->when($type == 'catholic', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'CATHO');
            })
            ->when($type == 'islam', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'MUSLI');
            })
            ->when($type == 'baptist', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'BAPTI');
            })
            ->when($type == 'bornagain', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'BRNAG');
            })
            ->when($type == 'buddist', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'BUDDH');
            })
            ->when($type == 'churchofgod', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'CHOG');
            })
            ->when($type == 'jehovah', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'JEWIT');
            })
            ->when($type == 'protestant', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'PROTE');
            })
            ->when($type == 'seventhday', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'SVDAY');
            })
            ->when($type == 'mormons', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'MORMO');
            })
            ->when($type == 'evangelical', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'EVANG');
            })
            ->when($type == 'pentecostal', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'PENTE');
            })
            ->when($type == 'unknown', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'UNKNO');
            })
            ->when($type == 'others', function ($q) use ($request, ) {
                $q->where('patients.religion_code', 'OTHERS');
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_medical_history($request, $type, $gender)
    {
        $others =
            "1,2,3,4,
             5,7,8,9,
             10,12,13,
             14,15,16,
             17,18,19";

        return DB::table('household_environmentals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('patient_histories', 'patients.id', 'patient_histories.patient_id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($type == 'hypertension', function ($q) use ($request) {
                $q->where('patient_histories.medical_history_id', 11);
            })
            ->when($type == 'diabetes', function ($q) use ($request, ) {
                $q->where('patient_histories.medical_history_id', 6);
            })
            ->when($type == 'tb', function ($q) use ($request, ) {
                $q->where('patient_histories.medical_history_id', 15);
            })
            ->when($type == 'others', function ($q) use ($request, $others) {
                $q->whereIn('patient_histories.medical_history_id', explode(',', $others));
            })
            ->whereCategory(1)
            ->whereGender($gender)
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->orderBy('registration_date', 'ASC');
    }

    public function get_household_profiling_age_group($request, $type, $gender)
    {
        return DB::table('household_environmentals')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address,
                        TIMESTAMPDIFF(YEAR, birthdate, registration_date) AS age_year,
                        TIMESTAMPDIFF(MONTH, birthdate, registration_date) % 12 AS age_month,
                        FLOOR(TIMESTAMPDIFF(DAY, birthdate, registration_date) % 28) AS age_day
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->whereGender($gender)
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->groupBy('patients.id')

            ///Age/Health RiskGroup Query
            ->when($type == 'newborn', function ($q) use ($request) {
                $q->havingRaw('(age_year = 0) AND (age_month = 0) AND (age_day BETWEEN 0 AND 28)');
            })
            ->when($type == 'infant', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 0 AND 1');
            })
            ->when($type == 'psac', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 1 AND 4');
            })
            ->when($type == 'sac', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 5 AND 9');
            })
            ->when($type == 'ad', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 10 AND 19');
            })
            ->when($type == 'adult', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 20 AND 59');
            })
            ->when($type == 'senior', function ($q) use ($request) {
                $q->havingRaw('age_year >= 60');
            })

            //Age Group
            ->when($type == '1-28days', function ($q) use ($request) {
                $q->havingRaw('(age_year = 0) AND (age_month = 0) AND (age_day BETWEEN 1 AND 28)');
            })
            ->when($type == '29-11months', function ($q) use ($request) {
                $q->havingRaw('(age_year = 0) AND (age_day >= 29 OR age_month BETWEEN 1 AND 11)');
            })
            ->when($type == '1-4years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 1 AND 4');
            })
            ->when($type == '5-9years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 5 AND 9');
            })
            ->when($type == '10-14years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 10 AND 14');
            })
            ->when($type == '15-19years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 15 AND 19');
            })
            ->when($type == '20-24years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 20 AND 24');
            })
            ->when($type == '25-29years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 25 AND 29');
            })
            ->when($type == '30-34years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 30 AND 34');
            })
            ->when($type == '35-39years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 35 AND 39');
            })
            ->when($type == '40-44years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 40 AND 44');
            })
            ->when($type == '45-49years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 45 AND 49');
            })
            ->when($type == '50-54years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 50 AND 54');
            })
            ->when($type == '55-59years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 50 AND 54');
            })
            ->when($type == '60-64years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 50 AND 54');
            })
            ->when($type == '65-69years', function ($q) use ($request) {
                $q->havingRaw('age_year BETWEEN 50 AND 54');
            })
            ->when($type == '70years', function ($q) use ($request) {
                $q->havingRaw('age_year >= 70');
            });
    }

    public function get_household_profiling_family_planning_method($request, $type, $method)
    {
        $others =
            "NFPCM,
             NFPSTM";

        $iud =
            "IUD,
             IUDPP";

        return DB::table('household_environmentals')
            ->selectRaw("
                        household_folders.id,
                        number_of_families,
                        CONCAT(address, ',', ' ', barangays.name, ',', ' ', municipalities.name, ',', ' ', provinces.name) AS address
                    ")
            ->join('household_folders', 'household_environmentals.household_folder_id', '=', 'household_folders.id')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->join('patient_fp_methods', 'patients.id', '=', 'patient_fp_methods.patient_id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('provinces', 'municipalities.geographic_id', '=', 'provinces.id')
//            ->join('patient_philhealth', 'patients.id', '=', 'patient_philhealth.patient_id')
//            ->join('lib_religions', 'patients.religion_code', '=', 'lib_religions.code')
//            ->join('lib_civil_statuses', 'patients.civil_status_code', '=', 'lib_civil_statuses.code')
//            ->join('lib_education', 'patients.education_code', '=', 'lib_education.code');
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'household_environmentals.facility_code');
            })
            ->when($type == '4ps', function ($q) use ($request) {
                $q->whereNotNull('cct_id');
            })
            ->when($type == 'non-4ps', function ($q) use ($request) {
                $q->whereNull('cct_id');
            })
            ->when($method == 'coc', function ($q) use ($request, $method) {
                $q->where('method_code', 'PILLS');
            })
            ->when($method == 'pop', function ($q) use ($request, $method) {
                $q->where('method_code', 'PILLSPOP');
            })
            ->when($method == 'injectables', function ($q) use ($request, $method) {
                $q->where('method_code', 'DMPA');
            })
            ->when($method == 'iud', function ($q) use ($request, $iud) {
                $q->whereIn('method_code', explode(',', $iud));
            })
            ->when($method == 'condom', function ($q) use ($request, $method) {
                $q->where('method_code', 'CONDOM');
            })
            ->when($method == 'lam', function ($q) use ($request, $method) {
                $q->where('method_code', 'NFPLAM');
            })
            ->when($method == 'btl', function ($q) use ($request, $method) {
                $q->where('method_code', 'FSTRBTL');
            })
            ->when($method == 'implant', function ($q) use ($request, $method) {
                $q->where('method_code', 'IMPLANT');
            })
            ->when($method == 'sdm', function ($q) use ($request, $method) {
                $q->where('method_code', 'NFPSDM');
            })
            ->when($method == 'vasectomy', function ($q) use ($request, $method) {
                $q->where('method_code', 'MSV');
            })
            ->when($method == 'bbt', function ($q) use ($request, $method) {
                $q->where('method_code', 'NFPBBT');
            })
            ->when($method == 'others', function ($q) use ($request, $others) {
                $q->whereIn('method_code', explode(',', $others));
            })
            ->whereBetween('registration_date', [$request->start_date, $request->end_date])
            ->groupBy('household_folders.id')
            ->orderBy('registration_date', 'ASC');
    }
}
