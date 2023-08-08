<?php

namespace App\Http\Resources\API\V1\Eclaims;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EclaimsCaserateListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'patient_id' => $this->patient_id,
            'program_desc' => $this->program_desc,
            'program_id' => $this->program_id,
            'admit_dx' => $this->admit_dx,
            'caserate_date' => $this->caserate_date,
            'caserate_code' => $this->caserate_code,
            'code' => $this->code,
            'description' => $this->description,
            'discharge_dx' => $this->discharge_dx,
            'icd10_code' => $this->icd10_code,
            'hci_fee' => $this->hci_fee,
            'prof_fee' => $this->prof_fee,
            'caserate_fee' => $this->caserate_fee,
            'caserate_attendant' => $this->caserate_attendant,
            'attendant' => $this->whenLoaded('caserateAttendant'),
            'enough_benefit_flag' => $this->enough_benefit_flag,
            'hci_pTotalActualCharges' => $this->hci_pTotalActualCharges,
            'hci_pDiscount' => $this->hci_pDiscount,
            'hci_pPhilhealthBenefit' => $this->hci_pPhilhealthBenefit,
            'hci_pTotalAmount' => $this->hci_pTotalAmount,
            'prof_pTotalActualCharges' => $this->prof_pTotalActualCharges,
            'prof_pDiscount' => $this->prof_pDiscount,
            'prof_pPhilhealthBenefit' => $this->prof_pPhilhealthBenefit,
            'prof_pTotalAmount' => $this->prof_pTotalAmount,
            'meds_flag' => $this->meds_flag,
            'meds_pDMSTotalAmount' => $this->meds_pDMSTotalAmount,
            'meds_pExaminations_flag' => $this->meds_pExaminations_flag,
            'meds_pExamTotalAmount' => $this->meds_pExamTotalAmount,
            'hmo_flag' => $this->hmo_flag,
            'others_flag' => $this->others_flag,
        ];
    }
}
