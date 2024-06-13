<?php

namespace App\Http\Resources\API\V1\Dental;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DentalOralHealthConditionResource extends JsonResource
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
            'consult_id' => $this->consult_id,

            'healthy_gums_flag' => $this->healthy_gums_flag,
            'orally_fit_flag' => $this->orally_fit_flag,
            'oral_rehab_flag' => $this->oral_rehab_flag,
            'dental_caries_flag' => $this->dental_caries_flag,
            'gingivitis_flag' => $this->gingivitis_flag,
            'periodontal_flag' => $this->periodontal_flag,
            'debris_flag' => $this->debris_flag,
            'calculus_flag' => $this->calculus_flag,
            'abnormal_growth_flag' => $this->abnormal_growth_flag,
            'cleft_lip_flag' => $this->cleft_lip_flag,
            'supernumerary_flag' => $this->supernumerary_flag,
            'dento_facial_flag' => $this->dento_facial_flag,
            'others_flag' => $this->others_flag,
            'remarks' => $this->remarks,
        ];
    }
}
