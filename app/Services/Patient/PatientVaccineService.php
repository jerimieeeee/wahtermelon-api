<?php

namespace App\Services\Patient;

use App\Models\V1\Libraries\LibLengthHeightForAge;
use App\Models\V1\Libraries\LibWeightForAge;
use App\Models\V1\Libraries\LibWeightForHeight;
use App\Models\V1\Patient\PatientVaccine;
use App\Models\V1\Patient\PatientVitals;
use Illuminate\Support\Facades\DB;

class PatientVaccineService
{
    public function get_immunize_status($patient_id)
    {

        $vax = $this->get_immunization_status($patient_id);

    }

    public function get_immunization_status($patient_id)
    {

        return DB::table(function ($query) use($patient_id){
            $query->selectRaw('
                SUM(CASE
                    WHEN vaccine_id = "BCG"
                    THEN 1
                    ELSE 0
                END) AS "BCG",
                SUM(CASE
                    WHEN vaccine_id = "PENTA"
                    THEN 1
                    ELSE 0
                END) AS "PENTA",
                SUM(CASE
                    WHEN vaccine_id = "OPV"
                    THEN 1
                    ELSE 0
                END) AS "OPV",
                SUM(CASE
                    WHEN vaccine_id = "MCV"
                    THEN 1
                    ELSE 0
                END) AS "MCV",
                SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN vaccine_id = "MCV"
                    THEN vaccine_date
                    ELSE NULL
                END ORDER BY vaccine_date ASC),",", 2),",", -1) AS vaccine_date,
                TIMESTAMPDIFF(MONTH, birthdate, SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN vaccine_id = "MCV"
                    THEN vaccine_date
                    ELSE NULL
                END ORDER BY vaccine_date ASC),",", 2),",", -1)) AS age_month,
                patient_id

            ')
            ->from('patient_vaccines')
            ->join('patients', 'patient_vaccines.patient_id', '=', 'patients.id')
            ->where('patient_id', $patient_id)
            ->groupBy('patient_id');

        })->selectRaw('
                CASE
                    WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=0 AND age_month < 13
                    THEN "FIC"
                    WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=0 AND age_month BETWEEN 13 AND 23
                    THEN "CIC"
                    WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=0 AND age_month >= 24
                    THEN "COMPLETED"
	            END AS immunization_status,
                vaccine_date
        ');

    }
}
