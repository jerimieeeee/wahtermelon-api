<?php

namespace App\Http\Resources\API\V1\Laboratory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultLaboratorySkinSlitSmearResource extends JsonResource
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
            'consult_id' => $this->when(! $this->relationLoaded('consult'), $this->consult_id),
            'consult' => $this->whenLoaded('consult'),
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->when($this->relationLoaded('user'), $this->user->first_name.' '.$this->user->middle_name.' '.$this->user->last_name),
            'laboratory_date' => $this->laboratory_date->format('Y-m-d'),
            'referral_facility' => $this->referral_facility,
            'request_id' => $this->when(! $this->relationLoaded('laboratoryRequest'), $this->request_id),
            'request' => $this->whenLoaded('laboratoryRequest'),

            'site_slit1' => $this->site_slit1,
            'site_slit2' => $this->site_slit2,
            'site_slit3' => $this->site_slit3,
            'site_slit4' => $this->site_slit4,
            'site_slit5' => $this->site_slit5,
            'site_slit6' => $this->site_slit6,

            'bac_index1' => $this->bac_index1,
            'bac_index2' => $this->bac_index2,
            'bac_index3' => $this->bac_index3,
            'bac_index4' => $this->bac_index4,
            'bac_index5' => $this->bac_index5,
            'bac_index6' => $this->bac_index6,

            'morp_index1' => $this->morp_index1,
            'morp_index2' => $this->morp_index2,
            'morp_index3' => $this->morp_index3,
            'morp_index4' => $this->morp_index4,
            'morp_index5' => $this->morp_index5,
            'morp_index6' => $this->morp_index6,

            'comment1' => $this->comment1,
            'comment2' => $this->comment2,
            'comment3' => $this->comment3,
            'comment4' => $this->comment4,
            'comment5' => $this->comment5,
            'comment6' => $this->comment6,

            'avg_bac_index' => $this->avg_bac_index,
            'avg_morp_index' => $this->avg_morp_index,

            'final_comment' => $this->final_comment,

            'remarks' => $this->remarks,
            'lab_status_code' => $this->when(! $this->relationLoaded('laboratoryStatus'), $this->lab_status_code),
            'lab_status' => $this->whenLoaded('laboratoryStatus'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
