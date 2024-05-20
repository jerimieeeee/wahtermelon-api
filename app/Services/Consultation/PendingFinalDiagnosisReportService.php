<?php

namespace App\Services\Consultation;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use Illuminate\Support\Facades\DB;

class PendingFinalDiagnosisReportService
{
    public function get_pending_fdx()
    {
        return DB::table('consults')
            ->selectRaw("
                        consults.patient_id,
                        consult_id,
                        consult_notes.id AS notes_id,
                        patients.birthdate AS birthdate,
                        DATE_FORMAT(consult_date, '%m/%d/%Y') AS consult_date,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        CONCAT('Dr. ', users.first_name, ' ', users.last_name) AS doctor,
                        CONCAT(users2.last_name, ',', ' ', users2.first_name, ' ', users2.middle_name) AS encoded,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, consults.consult_date) AS age
                    ")
            ->join('consult_notes', 'consults.id', '=', 'consult_notes.consult_id')
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftjoin('users', 'consults.physician_id', '=', 'users.id')
            ->leftJoin('users as users2', 'consults.user_id', '=', 'users2.id')
            ->leftJoin('consult_notes_final_dxes', 'consult_notes.id', '=', 'consult_notes_final_dxes.notes_id')
            ->wherePtGroup('cn')
            ->where('consults.facility_code', auth()->user()->facility_code)
            ->whereNull('icd10_code');
    }
}
