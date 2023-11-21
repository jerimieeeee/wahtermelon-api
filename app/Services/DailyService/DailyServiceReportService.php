<?php

namespace App\Services\DailyService;

use App\Models\V1\Patient\Patient;
use Illuminate\Support\Facades\DB;

class DailyServiceReportService
{
    public function get_daily_service($request)
    {
        return Patient::with(['consults', 'address.barangays', 'philhealth_id', 'vitals', 'consult_notes', 'initial_dx.diagnosis', 'final_dx.libIcd10'])
            ->join('consults', 'patients.id', '=', 'consults.patient_id')
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->selectRaw("CONCAT(patients.last_name, ', ', patients.first_name) AS patient_name")
            ->addSelect(['patients.id',
                         'gender',
                         'birthdate AS birthday',
                         'consent_flag AS with_consent'
                    ])
//            ->addSelect('birthdate')
//            ->addSelect('address')
            ->selectRaw("TIMESTAMPDIFF(YEAR, patients.birthdate, consults.consult_date) AS age")
            ->whereHas('consult',function($q) use($request) {
                $q->whereBetween('consult_date',  array($request->start_date, $request->end_date));
            })
            ->get();
    }
}
