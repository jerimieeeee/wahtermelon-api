<?php

namespace App\Http\Resources\API\V1\Patient;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientVitalsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->vitals_id ?? $this->id,
            'facility_code' => $this->when(!$this->relationLoaded('facility'),$this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_id' => $this->when(!$this->relationLoaded('patient'),$this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(!$this->relationLoaded('user'),$this->user_id),
            'user' => $this->whenLoaded('user'),
            'vitals_date' => Carbon::parse($this->vitals_date)->format('Y-m-d H:i:s'),
            'patient_age_years' => $this->patient_age_years,
            'patient_age_months' => $this->patient_age_months,
            'patient_temp' => $this->patient_temp,
            'patient_height' => $this->patient_height,
            'patient_weight' => $this->patient_weight,
            'patient_bmi' => $this->patient_bmi,
            'patient_bmi_class' => $this->patient_bmi_class,
            'patient_weight_for_age' => $this->patient_weight_for_age,
            'patient_height_for_age' => $this->patient_height_for_age,
            'patient_weight_for_height' => $this->patient_weight_for_height,
            'patient_head_circumference' => $this->patient_head_circumference,
            'patient_skinfold_thickness' => $this->patient_skinfold_thickness,
            'bp_systolic' => $this->bp_systolic,
            'bp_diastolic' => $this->bp_diastolic,
            'patient_heart_rate' => $this->patient_heart_rate,
            'patient_respiratory_rate' => $this->patient_respiratory_rate,
            'patient_pulse_rate' => $this->patient_pulse_rate,
            'patient_spo2' => $this->patient_spo2,
            'patient_chest' => $this->patient_chest,
            'patient_abdomen' => $this->patient_abdomen,
            'patient_waist' => $this->patient_waist,
            'patient_hip' => $this->patient_hip,
            'patient_limbs' => $this->patient_limbs,
            'patient_muac' => $this->patient_muac,
            'patient_left_vision_acuity' => $this->patient_left_vision_acuity,
            'patient_right_vision_acuity' => $this->patient_right_vision_acuity,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
