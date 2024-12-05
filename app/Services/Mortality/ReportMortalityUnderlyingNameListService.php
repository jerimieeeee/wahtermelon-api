<?php

namespace App\Services\Mortality;
use App\Services\ReportFilter\CategoryFilterService;

use Illuminate\Support\Facades\DB;

class ReportMortalityUnderlyingNameListService
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
    }

    public function get_report_namelist($request)
    {
        return DB::table('patient_death_records')
            ->selectRaw("
                        patient_death_records.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
                        ")
            ->join('patient_death_record_causes', 'patient_death_records.id', '=', 'patient_death_record_causes.death_record_id')
            ->join('patients', 'patient_death_records.patient_id', '=', 'patients.id')
            ->join('lib_icd10s', 'patient_death_record_causes.icd10_code', '=', 'lib_icd10s.icd10_code')
            ->join('users', 'patient_death_record_causes.user_id', '=', 'users.id')
            ->where('patient_death_record_causes.cause_code', 'UND')
            ->where('patient_death_record_causes.icd10_code', $request->icd10_code)
            ->whereBetween(DB::raw('DATE(date_of_death)'), [$request->start_date, $request->end_date])
//            ->whereYear('date_of_death', $request->year)
//            ->whereMonth('date_of_death', $request->month)
            //male_0_to_6_days
            ->when($request->params == 'male_0_to_6_days', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) BETWEEN 0 AND 6");
            })
            //male_7_to_28_days
            ->when($request->params == 'male_7_to_28_days', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) BETWEEN 7 AND 28");
            })
            //male_29_days_to_11_months
            ->when($request->params == 'male_29_days_to_11_months', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) = 29")
                    ->orWhere(function ($query) use ($request) {
                        $query->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 9 AND 11");
                    });
            })
            //male_1_to_4_years
            ->when($request->params == 'male_1_to_4_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 1 AND 4");
            })
            //male_5_to_9_years
            ->when($request->params == 'male_5_to_9_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 5 AND 9");
            })
            //male_10_to_14_years
            ->when($request->params == 'male_10_to_14_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 10 AND 14");
            })
            //male_15_to_19_years
            ->when($request->params == 'male_15_to_19_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 15 AND 19");
            })
            //male_20_to_24_years
            ->when($request->params == 'male_20_to_24_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 20 AND 24");
            })
            //male_25_to_29_years
            ->when($request->params == 'male_15_to_19_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 25 AND 29");
            })
            //male_30_to_34_years
            ->when($request->params == 'male_15_to_19_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 30 AND 34");
            })
            //male_35_to_39_years
            ->when($request->params == 'male_35_to_39_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 35 AND 39");
            })
            //male_40_to_44_years
            ->when($request->params == 'male_40_to_44_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 40 AND 44");
            })
            //male_45_to_49_years
            ->when($request->params == 'male_45_to_49_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 45 AND 49");
            })
            //male_50_to_54_years
            ->when($request->params == 'male_50_to_54_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 50 AND 54");
            })
            //male_55_to_59_years
            ->when($request->params == 'male_55_to_59_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 55 AND 59");
            })
            //male_60_to_64_years
            ->when($request->params == 'male_60_to_64_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 60 AND 64");
            })
            //male_65_to_69_years
            ->when($request->params == 'male_65_to_69_years', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 65 AND 69");
            })
            //male_70_years_above
            ->when($request->params == 'male_70_years_above', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) >= 70");
            })
            //female_0_to_6_days
            ->when($request->params == 'female_0_to_6_days', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) BETWEEN 0 AND 6");
            })
            //female_7_to_28_days
            ->when($request->params == 'female_7_to_28_days', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) BETWEEN 7 AND 28");
            })
            //female_29_days_to_11_months
            ->when($request->params == 'female_29_days_to_11_months', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(DAY, patients.birthdate, patient_death_records.date_of_death) = 29")
                    ->orWhere(function ($query) use ($request) {
                        $query->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 9 AND 11");
                    });
            })
            //female_1_to_4_years
            ->when($request->params == 'female_1_to_4_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 1 AND 4");
            })
            //female_5_to_9_years
            ->when($request->params == 'female_5_to_9_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 5 AND 9");
            })
            //female_10_to_14_years
            ->when($request->params == 'female_10_to_14_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 10 AND 14");
            })
            //female_15_to_19_years
            ->when($request->params == 'female_15_to_19_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 15 AND 19");
            })
            //female_20_to_24_years
            ->when($request->params == 'female_20_to_24_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 20 AND 24");
            })
            //female_25_to_29_years
            ->when($request->params == 'female_15_to_19_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 25 AND 29");
            })
            //female_30_to_34_years
            ->when($request->params == 'female_15_to_19_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 30 AND 34");
            })
            //female_35_to_39_years
            ->when($request->params == 'female_35_to_39_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 35 AND 39");
            })
            //female_40_to_44_years
            ->when($request->params == 'female_40_to_44_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 40 AND 44");
            })
            //female_45_to_49_years
            ->when($request->params == 'female_45_to_49_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 45 AND 49");
            })
            //female_50_to_54_years
            ->when($request->params == 'female_50_to_54_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 50 AND 54");
            })
            //female_55_to_59_years
            ->when($request->params == 'female_55_to_59_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 55 AND 59");
            })
            //female_60_to_64_years
            ->when($request->params == 'female_60_to_64_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 60 AND 64");
            })
            //female_65_to_69_years
            ->when($request->params == 'female_65_to_69_years', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) BETWEEN 65 AND 69");
            })
            //female_70_years_above
            ->when($request->params == 'female_70_years_above', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, patient_death_records.date_of_death) >= 70");
            })
            ->when($request->type == 'total_male', function ($q) use ($request) {
                $q->where('patients.gender', 'M');
            })
            ->when($request->type == 'total_female', function ($q) use ($request) {
                $q->where('patients.gender', 'F');
            })
            ->when($request->type == 'total_both', function ($q) use ($request) {
                $q->whereIn('patients.gender', ['M', 'F']);
            })
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_death_records.facility_code', 'patient_death_records.patient_id');
            })
            ->groupBy('patient_death_record_causes.icd10_code');
    }
}
