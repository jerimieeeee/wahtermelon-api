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
                        consult_notes.id AS notes_id,
                        DATE_FORMAT(consult_date, '%Y-%m-%d') AS consult_date,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        birthdate,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name
                    ")
            ->join('consult_notes', 'consults.id', '=', 'consult_notes.consult_id')
            ->join('patients', 'consults.patient_id', '=', 'patients.id')
            ->leftJoin('consult_notes_final_dxes', 'consult_notes.id', '=', 'consult_notes_final_dxes.notes_id')
            ->wherePtGroup('cn')
            ->where('consults.facility_code', auth()->user()->facility_code)
            ->whereNull('icd10_code');
    }
}
