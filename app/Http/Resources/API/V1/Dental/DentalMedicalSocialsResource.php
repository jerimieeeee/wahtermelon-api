<?php

namespace App\Http\Resources\API\V1\Dental;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DentalMedicalSocialsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->notes_id,
            'facility_code' => $this->facility_code,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,

            'allergies_flag' => $this->allergies_flag,
            'hypertension_flag' => $this->hypertension_flag,
            'diabetes_flag' => $this->diabetes_flag,
            'blood_disorder_flag' => $this->blood_disorder_flag,
            'heart_disease_flag' => $this->heart_disease_flag,
            'thyroid_flag' => $this->thyroid_flag,
            'hepatitis_flag' => $this->hepatitis_flag,
            'malignancy_flag' => $this->malignancy_flag,
            'blood_transfusion_flag' => $this->blood_transfusion_flag,
            'tattoo_flag' => $this->tattoo_flag,
            'medical_remarks' => $this->medical_remarks,
            'sweet_flag' => $this->sweet_flag,
            'tabacco_flag' => $this->tabacco_flag,
            'alcohol_flag' => $this->alcohol_flag,
            'nut_flag' => $this->nut_flag,
            'social_others_flag' => $this->social_others_flag,
            'social_remarks' => $this->social_remarks,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
