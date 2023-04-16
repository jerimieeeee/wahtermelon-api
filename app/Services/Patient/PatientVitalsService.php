<?php

namespace App\Services\Patient;

use App\Models\V1\Libraries\LibLengthHeightForAge;
use App\Models\V1\Libraries\LibWeightForAge;
use App\Models\V1\Libraries\LibWeightForHeight;
use App\Models\V1\Patient\PatientVitals;

class PatientVitalsService
{
    public function get_patient_bmi()
    {
        $weight = '';
        $height = '';
        $bmi = '';
        $bmiClass = '';
        if (isset(request()->patient_height) && isset(request()->patient_weight)) {
            $height = request()->patient_height;
            $weight = request()->patient_weight;
        } elseif (isset(request()->patient_height) && ! isset(request()->patient_weight)) {
            $data = PatientVitals::select('patient_weight')
                ->wherePatientId(request()->patient_id)
                ->whereNotNull('patient_weight')
                ->orderBy('vitals_date', 'DESC')
                ->first();
            $height = request()->patient_height;
            $weight = $data ? $data->patient_weight : null;
        } elseif (! isset(request()->patient_height) && isset(request()->patient_weight)) {
            $data = PatientVitals::select('patient_height')
                ->wherePatientId(request()->patient_id)
                ->whereNotNull('patient_height')
                ->orderBy('vitals_date', 'DESC')
                ->first();
            $height = $data ? $data->patient_height : null;
            $weight = request()->patient_weight;
        } else {
            /*$data = PatientVitals::select('patient_height', 'patient_weight')->addSelect([
                'patient_height' => PatientVitals::select('patient_height')
                    ->whereColumn('patient_id', 'patient_vitals.patient_id')
                    ->whereNotNull('patient_height')
                    ->orderBy('vitals_date', 'DESC')->limit(1),
                'patient_weight' => PatientVitals::select('patient_weight')
                    ->whereColumn('patient_id', 'patient_vitals.patient_id')
                    ->whereNotNull('patient_weight')
                    ->orderBy('vitals_date', 'DESC')->limit(1),
            ])
                ->wherePatientId(request()->patient_id)->havingRaw('patient_height IS NOT NULL AND patient_weight IS NOT NULL')
                ->orderBy('vitals_date', 'DESC')
                ->toBase()
                ->first();*/
            $patientWeight = PatientVitals::select('patient_weight')
                ->wherePatientId(request()->patient_id)
                ->whereNotNull('patient_weight')
                ->orderBy('vitals_date', 'DESC')
                ->first();
            $patientHeight = PatientVitals::select('patient_height')
                ->wherePatientId(request()->patient_id)
                ->whereNotNull('patient_height')
                ->orderBy('vitals_date', 'DESC')
                ->first();
            $height = $patientHeight ? $patientHeight->patient_height : null;
            $weight = $patientWeight ? $patientWeight->patient_weight : null;
        }

        if ($weight != null && $height != null) {
            [$bmi, $bmiClass] = compute_bmi($weight, $height);
        }

        return [$weight, $height, $bmi, $bmiClass];
    }

    public function get_weight_for_age($ageMonth, $gender, $weight)
    {
        $weightForAge = LibWeightForAge::query()
            ->whereAgeMonth($ageMonth)
            ->whereGender($gender)
            ->whereRaw("
                (CASE
                    WHEN weight_min = weight_max AND wt_class = 'Severely Underweight'
                    THEN ? <= weight_max
                    WHEN weight_min = weight_max AND wt_class = 'Overweight'
                    THEN ? >= weight_max
                    ELSE ? BETWEEN weight_min AND weight_max
                END)
            ", [$weight, $weight, $weight])
            ->toBase()
            ->first();

        return $weightForAge;
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
            ->whereRaw('? BETWEEN age_min AND age_max', $ageMonth)
            ->whereGender($gender)
            ->whereRaw('height_cm = (CEILING(? / 0.5) * 0.5)', $height)
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
