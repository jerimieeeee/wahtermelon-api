<?php

namespace App\Services\Dental;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class ReportDentalNameListService
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
        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        consult_date AS date_of_service
                        ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('dental_oral_health_conditions', 'consults.id', '=', 'dental_oral_health_conditions.consult_id')
            ->leftJoin('dental_tooth_services', 'consults.id', '=', 'dental_tooth_services.consult_id')
            ->leftJoin('dental_services', 'consults.id', '=', 'dental_services.consult_id')
            ->leftJoin('dental_tooth_conditions', 'consults.id', '=', 'dental_tooth_conditions.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            // orally fit 12-59 months male
            ->when($request->params == 'male_12_59_months_orally_fit', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->where('orally_fit_flag', 1)
                    ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 12 AND 59");
            })
            // orally fit 12-59 months female
            ->when($request->params == 'female_12_59_months_orally_fit', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->where('orally_fit_flag', 1)
                    ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 12 AND 59");
            })
           // orally fit 12-59 months total male and female
            ->when($request->params == 'male_female_12_59_months_orally_fit', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F'])
                    ->where('orally_fit_flag', 1)
                    ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 12 AND 59");
            })
            // male dental dmft
           ->when($request->params == 'male_dental_dmft', function ($query) use ($request) {
                 $query->where('patients.gender', 'M')
                    ->whereIn('tooth_number',
                        [
                            '11', '12', '13', '14', '15', '16', '17',
                            '18', '21', '22', '23', '24', '25', '26',
                            '27', '28', '41', '42', '43', '44', '45',
                            '46', '47', '48', '31', '32', '33', '34',
                            '35', '36', '37', '38'
                        ]
                    )
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consults.consult_date) >= 5")
                ->distinct();
            })
            // female dental dmft
            ->when($request->params == 'female_dental_dmft', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('tooth_number',
                        [
                            '11', '12', '13', '14', '15', '16', '17',
                            '18', '21', '22', '23', '24', '25', '26',
                            '27', '28', '41', '42', '43', '44', '45',
                            '46', '47', '48', '31', '32', '33', '34',
                            '35', '36', '37', '38'
                        ]
                    )
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consults.consult_date) >= 5")
                ->distinct();
            })
            // male 0 to 11 months BOHC
            ->when($request->client_code == 'male_0_11_months_bohc', function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('patients.gender', 'M')
                            ->whereIn('service_id',
                                [1, 6, 7]
                            )
                            ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 8");
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('patients.gender', 'M')
                            ->whereIn('service_id',
                                [1, 6, 7]
                            )
                            ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 9 AND 11");
                    });
                });
            })
            // female 0 to 11 months BOHC
            ->when($request->client_code == 'female_0_11_months_bohc', function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('patients.gender', 'F')
                            ->whereIn('service_id',
                                [1, 6, 7]
                            )
                            ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 0 AND 8");
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('patients.gender', 'F')
                            ->whereIn('service_id',
                                [1, 6, 7, 17]
                            )
                            ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, consult_date) BETWEEN 9 AND 11");
                    });
                });
            })
            // male 1 to 4 years BOHC
            ->when($request->params == 'male_1_4_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereIn('service_id',
                        [7, 17, 15, 8]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4");
            })
            // female 1 to 4 years BOHC
            ->when($request->params == 'female_1_4_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('service_id',
                        [7, 17, 15, 8]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 1 AND 4");
            })
            // male 5 to 9 years BOHC
            ->when($request->params == 'male_5_9_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereIn('service_id',
                        [7, 15, 8]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9");
            })
            // female 5 to 9 years BOHC
            ->when($request->params == 'female_5_9_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('service_id',
                        [7, 15, 8]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 5 AND 9");
            })
            // male 10 to 19 years BOHC
            ->when($request->params == 'male_10_19_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereIn('service_id',
                        [7, 4]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19");
            })
            // female 10 to 19 years BOHC
            ->when($request->params == 'female_10_19_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('service_id',
                        [7, 4]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 19");
            })
            // male 20 to 59 years BOHC
            ->when($request->params == 'male_20_59_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereIn('service_id',
                        [7, 4]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59");
            })
            // female 20 to 59 years BOHC
            ->when($request->params == 'female_20_59_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('service_id',
                        [7, 4]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 59");
            })
            // male 60 years above BOHC
            ->when($request->params == 'male_60_above_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereIn('service_id',
                        [7, 4]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60");
            })
            // female 60 years above BOHC
            ->when($request->params == 'female_60_above_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('service_id',
                        [7, 4]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) >= 60");
            })
            // pregnant 10 to 14 years BOHC
            ->when($request->params == 'pregnant_women_10_14_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('service_id',
                        [7, 4]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 10 AND 14");
            })
            // pregnant 15 to 19 years BOHC
            ->when($request->params == 'pregnant_women_15_19_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('service_id',
                        [7, 4]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 15 AND 19");
            })
            // pregnant 20 to 49 years BOHC
            ->when($request->params == 'pregnant_women_20_49_years_bohc', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('service_id',
                        [7, 4]
                    )
                    ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consult_date) BETWEEN 20 AND 49");
            })
            ->wherePtGroup('dn')
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->groupBy('consults.patient_id');
    }

    public function get_dental_dmft($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        consult_date AS date_of_service
                        ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('dental_oral_health_conditions', 'consults.id', '=', 'dental_oral_health_conditions.consult_id')
            ->leftJoin('dental_tooth_services', 'consults.id', '=', 'dental_tooth_services.consult_id')
            ->leftJoin('dental_services', 'consults.id', '=', 'dental_services.consult_id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            // male dental dmft
            ->when($request->params == 'male_dental_dmft', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereIn('tooth_number',
                        [
                            '11', '12', '13', '14', '15', '16', '17',
                            '18', '21', '22', '23', '24', '25', '26',
                            '27', '28', '41', '42', '43', '44', '45',
                            '46', '47', '48', '31', '32', '33', '34',
                            '35', '36', '37', '38'
                        ]
                    )
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consults.consult_date) >= 5");
            })
            // female dental dmft
            ->when($request->params == 'female_dental_dmft', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('tooth_number',
                        [
                            '11', '12', '13', '14', '15', '16', '17',
                            '18', '21', '22', '23', '24', '25', '26',
                            '27', '28', '41', '42', '43', '44', '45',
                            '46', '47', '48', '31', '32', '33', '34',
                            '35', '36', '37', '38'
                        ]
                    )
                ->whereRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consults.consult_date) >= 5");
            })
            ->whereBetween(DB::raw('DATE(consult_date)'), [$request->start_date, $request->end_date])
//            ->whereYear('consult_date', $request->year)
//            ->whereMonth('consult_date', $request->month)
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->groupBy('consults.patient_id');
    }
}
