<?php

namespace App\Services\FamilyPlanning;

use Illuminate\Support\Facades\DB;
use App\Services\ReportFilter\CategoryFilterService;

class ReportFamilyPlanningNameListService
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
//            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
//            ->groupBy('patient_id', 'municipalities.psgc_10_digit_code', 'barangays.psgc_10_digit_code');
    }

    public function get_report_namelist($request)
    {
        return DB::table('patient_fp_methods')
            ->selectRaw("
                        patient_fp_methods.patient_id AS patient_id,
                        patient_fp_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate,
                        patient_fp_methods.id
                        ")
            ->join('patients', 'patient_fp_methods.patient_id', '=', 'patients.id')
            ->join('users', 'patient_fp_methods.user_id', '=', 'users.id')
            ->whereNull('patient_fp_methods.deleted_at')
            ->when($request->client_code == 'current_user_beginning_month', function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereClientCode('CU')
                            ->where(function($query) use ($request) {
                                $query->whereNull('dropout_date')
                                ->orWhereRaw("DATE_FORMAT(dropout_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0'))", [$request->year, $request->month]);
                            })
                            ->whereRaw("DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(?, '-', LPAD(?, 2, '0'))", [$request->year, $request->month]);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->whereClientCode('NA')
                            ->where(function($query) use($request){
                                $query->whereNull('dropout_date')
                                    ->orWhereRaw("DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0'))", [$request->year, $request->month]);
                            })
                            ->whereRaw("DATE_FORMAT(enrollment_date, '%Y-%m') <=
                                CONCAT(IF(? <= 2, ? - 1, ?), '-', LPAD(IF(? <= 2, ? + 10, ? - 2), 2, '0'))",
                                [$request->month, $request->year, $request->year,
                                $request->month, $request->month, $request->month]
                            );
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->whereIn('client_code', ['CC', 'CM', 'RS'])
                            ->where(function($query) use($request) {
                                $query->whereNull('dropout_date')
                                    ->orWhereRaw("DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-', LPAD(?, 2, '0'))", [$request->year, $request->month]);
                            })
                            ->whereRaw("DATE_FORMAT(enrollment_date, '%Y-%m') <= CONCAT(IF(? = 1, ? - 1, ?), '-', LPAD(IF(? = 1, 12, ? - 1), 2, '0'))",
                                [$request->month, $request->year, $request->year, $request->month, $request->month]
                        );
                    });
                });
            })
            ->when($request->client_code == 'new_acceptor_previous_month', function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereClientCode('NA')
                            ->where(function($query) use ($request) {
                                $query->whereNull('dropout_date')
                                    ->orWhereRaw("DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(IF(? = 1, ? - 1, ?), '-',
                                            LPAD(IF(? = 1, 12, ? - 1), 2, '0'))",
                                    [$request->month, $request->year, $request->year, $request->month, $request->month]
                                );
                            })
                            ->whereRaw("IF(? = 1, (MONTH(enrollment_date) = 12 AND YEAR(enrollment_date) = ? - 1),
                                (MONTH(enrollment_date) = ? - 1 AND YEAR(enrollment_date) = ?))",
                                [$request->month, $request->year, $request->month, $request->year]
                        );
                    });
                });
            })
            ->when($request->client_code == 'other_acceptor_present_month', function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereIn('client_code', ['CC', 'CM', 'RS'])
                            ->whereRaw("DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-', LPAD(?, 2, '0'))",
                                [$request->year, $request->month]);
                    });
                });
            })
            ->when($request->client_code == 'dropout_present_month', function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereNotNull('dropout_date')
                            ->whereRaw("DATE_FORMAT(dropout_date, '%Y-%m') = CONCAT(?, '-',LPAD(?, 2, '0'))",
                                [$request->year, $request->month]
                            );
                    });
                });
            })
            ->when($request->client_code == 'new_acceptor_present_month', function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->whereClientCode('NA')
                        ->where(function($query) use ($request) {
                            $query->whereNull('dropout_date')
                                ->orWhereRaw("DATE_FORMAT(dropout_date, '%Y-%m') >= CONCAT(?, '-',LPAD(?, 2, '0'))",
                                    [$request->year, $request->month]
                        );
                    })
                    ->whereRaw("DATE_FORMAT(enrollment_date, '%Y-%m') = CONCAT(?, '-',LPAD(?, 2, '0'))",
                        [$request->year, $request->month]
                    );
                });
            })
            ->when($request->client_code == 'dropout_present_month', function($query) use ($request) {
                $query->whereBetween(DB::raw("TIMESTAMPDIFF(YEAR, patients.birthdate, dropout_date)"), $request->age);
            })
            ->when($request->client_code !== 'dropout_present_month', function($query) use ($request) {
                $query->whereBetween(DB::raw("TIMESTAMPDIFF(YEAR, patients.birthdate, NOW())"), $request->age);
            })
            ->whereMethodCode($request->method)
            //->where('patient_fp_methods.facility_code', auth()->user()->facility_code)
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'patient_fp_methods.facility_code', 'patient_fp_methods.patient_id');
            })
            ->groupBy('patient_fp_methods.patient_id')
            ->orderBy('name');
    }
}
