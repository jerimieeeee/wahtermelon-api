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

    public function get_master_list($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        patients.birthdate,
                        patients.gender,
                        DATE_FORMAT(consults.consult_date, '%Y-%m-%d') AS date_of_service,
                        CONCAT(household_folders.address, ',', ' ', barangays.name, ',', ' ', municipalities.name) AS address
                    ")
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('household_members', 'consults.patient_id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->join('users', 'consults.user_id', '=', 'users.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consults.facility_code', 'consults.patient_id');
            })
            ->where('pt_group', $request->pt_group)
            ->whereBetween('consult_date', [
                $request->start_date . ' 00:00:00', // Start of the day
                $request->end_date . ' 23:59:59'    // End of the day
            ])
            ->orderBy('name', 'ASC');
    }
}
