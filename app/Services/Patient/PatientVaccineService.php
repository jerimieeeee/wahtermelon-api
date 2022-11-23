<?php

namespace App\Services\Patient;

use App\Models\V1\Libraries\LibLengthHeightForAge;
use App\Models\V1\Libraries\LibWeightForAge;
use App\Models\V1\Libraries\LibWeightForHeight;
use App\Models\V1\Patient\PatientVaccine;
use App\Models\V1\Patient\PatientVitals;

class PatientVaccineService
{
    public function get_immunization_status($patient_id)
    {
        $status = PatientVaccine::query()
            ->wherePatientId($patient_id)
            ->whereRaw("
            CASE
                WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=0 AND age_month < 13
                THEN 'FIC'
                WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=0 AND age_month BETWEEN 13 AND 23
                THEN 'CIC'
                WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=0 AND age_month >= 24
                THEN 'COMPOLETED'
                ELSE 'SURVIVOR'
            END AS immunizatio_status"
            )
            ->whereRaw("
            SUM(CASE
			    WHEN vaccine_id = 'BCG'
			    THEN 1
			    ELSE 0
		    END) AS 'BCG',
            ")

        }

    public function get_height_for_age($ageMonth, $gender, $height)
    {
        $heightForAge = LibLengthHeightForAge::query()
            ->whereAgeMonth($ageMonth)
            ->whereGender($gender)
            ->whereRaw("
                (CASE
                    WHEN length_min = length_max AND lt_class = 'Severely Stunted'
                    THEN ? <= length_max
                    WHEN length_min = length_max AND lt_class = 'Tall'
                    THEN ? >= length_max
                    ELSE ? BETWEEN length_min AND length_max
                END)
            ", [$height, $height, $height])
            ->toBase()
            ->first();
        return $heightForAge;
    }

    public function get_weight_for_height($ageMonth, $gender, $weight, $height)
    {
        $weightForHeight = LibWeightForHeight::query()
            ->whereRaw("? BETWEEN age_min AND age_max", $ageMonth)
            ->whereGender($gender)
            ->whereRaw("height_cm = (CEILING(? / 0.5) * 0.5)", $height)
            ->whereRaw("
                (CASE
                    WHEN weight_min = weight_max AND wt_class = 'Severely Wasted'
                    THEN ? <= weight_max
                    WHEN weight_min = weight_max AND wt_class = 'Obese'
                    THEN ? >= weight_max
                    ELSE ? BETWEEN weight_min AND weight_max
                END)
            ", [$weight, $weight, $weight])
            ->toBase()
            ->first();
        return $weightForHeight;
    }

}
