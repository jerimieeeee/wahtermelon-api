<?php

namespace App\Services\Consultation;

use App\Models\V1\Consultation\Consult;
use Illuminate\Support\Facades\DB;

class PendingFinalDiagnosisReportService
{
    public function get_pending_fdx($request)
    {
        return Consult::with(['consultNotes', 'physician', 'user'])
            ->whereYear('consult_date', '>=', '2023')
            ->when($request->filled('physician_id'), function ($q) use ($request) {
                $q->where('physician_id', $request->physician_id);
            })
            ->where('consult_done', 1)
            ->where(function ($query) {
                $query->whereNotNull('physician_id')
                    ->whereDoesntHave('finalDiagnosis');
/*//             with Initial without doctor referred
            ->where(function ($query) {
                $query->whereHas('initialDiagnosis')
                    ->whereNull('physician_id')
                    ->whereDoesntHave('finalDiagnosis')
                    // without Initial with doctor referred
                    ->orWhere(function ($query) {
                        $query->whereDoesntHave('initialDiagnosis')
                            ->whereNotNull('physician_id')
                            ->whereDoesntHave('finalDiagnosis');
                    });
            });*/
        });
    }

/*        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id,
                        consult_id,
                        consult_notes.id AS notes_id,
                        patients.birthdate AS birthdate,
                        DATE_FORMAT(consult_date, '%m/%d/%Y') AS consult_date,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ' ', patients.middle_name) AS name,
                        CONCAT('Dr. ', users.first_name, ' ', users.last_name) AS doctor,
                        CONCAT(users2.last_name, ',', ' ', users2.first_name, ' ', users2.middle_name) AS encoded,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, consults.consult_date) AS age
                    ")
            ->join('consult_notes', 'consults.id', '=', 'consult_notes.consult_id')
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->join('users', 'consults.physician_id', '=', 'users.id')
            ->join('users as users2', 'consults.user_id', '=', 'users2.id')
            ->leftJoin('consult_notes_initial_dxes', 'consult_notes.id', '=', 'consult_notes_initial_dxes.notes_id')
            ->leftJoin('consult_notes_final_dxes', 'consult_notes.id', '=', 'consult_notes_final_dxes.notes_id')
            ->where('consults.pt_group', '=', 'cn')
            ->where('consults.facility_code', auth()->user()->facility_code)
            //with Initial without doctor referred
            ->where(
                function($query) {
                    return $query
                        ->whereHas('consult_notes_initial_d')
                        ->whereNull('consults.physician_id')
                        ->whereDoesntHave('consult_notes_final_dxes.icd10_code');
//                        ->where('consults.facility_code', auth()->user()->facility_code);
                })
            //without Initial with doctor referred
            ->orWhere(
                function($query) {
                    return $query
                        ->whereNull('consult_notes_initial_dxes.class_id')
                        ->whereNotNull('consults.physician_id')
                        ->whereNull('consult_notes_final_dxes.icd10_code');
//                        ->where('consults.facility_code', auth()->user()->facility_code);
                });*/
}
