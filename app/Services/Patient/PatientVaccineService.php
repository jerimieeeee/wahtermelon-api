<?php

namespace App\Services\Patient;

use Illuminate\Support\Facades\DB;

class PatientVaccineService
{
    public function get_fic_cic($patient_id)
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                            fic_cic_vaccines.patient_id AS patient_id,
                            BCG,
                            PENTA,
                            OPV,
                            MCV,
                            immunization_date,
                            fic_cic_vaccines.status_id,
                            age_month
                ")
                ->from('patient_vaccines')
                ->joinSub($this->get_fic_cic_vaccines(), 'fic_cic_vaccines', function ($join) {
                    $join->on('fic_cic_vaccines.patient_id', '=', 'patient_vaccines.patient_id');
                })
                ->whereIn('vaccine_id', ['BCG', 'PENTA', 'OPV', 'MCV'])
                ->groupBy('patient_vaccines.patient_id', 'patient_vaccines.vaccine_date', 'vaccine_id', 'status_id');
            })
            ->selectRaw('
                        immunization_date,
                       CASE
                            WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month < 13
                            THEN "FIC"
                            WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month BETWEEN 13 AND 23
                            THEN "CIC"
                            WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month >= 24
                            THEN "COMPLETED"
                            END AS immunization_status

            ')
            ->wherePatientId($patient_id);
    }

    public function get_fic_cic_vaccines()
    {
        return DB::table(function ($query) {
            $query->selectRaw("
                        patient_id,
                        vaccine_id,
                        birthdate,
                        vaccine_date,
                        status_id
            ")
                ->from('patient_vaccines')
                ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
                ->whereIn('vaccine_id', ['BCG', 'PENTA', 'OPV', 'MCV'])
                ->groupBy('patient_id', 'vaccine_date', 'status_id', 'vaccine_id');
        })
        ->selectRaw("
                    patient_id,
                    birthdate,
                    MAX(vaccine_date) AS immunization_date,
                    TIMESTAMPDIFF(MONTH, birthdate, MAX(vaccine_date)) AS age_month,
                    SUM(
                        CASE WHEN vaccine_id = 'BCG' THEN
                            1
                        ELSE
                            0
                        END) AS 'BCG',
                    SUM(
                        CASE WHEN vaccine_id = 'PENTA' THEN
                            1
                        ELSE
                            0
                        END) AS 'PENTA',
                    SUM(
                        CASE WHEN vaccine_id = 'OPV' THEN
                            1
                        ELSE
                            0
                        END) AS 'OPV',
                    SUM(
                        CASE WHEN vaccine_id = 'MCV' THEN
                            1
                        ELSE
                            0
                        END) AS 'MCV',
                    SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(status_id ORDER BY status_id DESC), ',', 1), ',', -1) AS status_id
        ")
        ->groupBy('patient_id');
    }
}
