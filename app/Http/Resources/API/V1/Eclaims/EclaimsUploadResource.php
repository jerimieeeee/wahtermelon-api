<?php

namespace App\Http\Resources\API\V1\Eclaims;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EclaimsUploadResource extends JsonResource
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
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'denied_reason' => $this->denied_reason,
            'program_desc' => $this->program_desc,
            'eclaims_caserate_list_id' => $this->when(! $this->relationLoaded('caserate'), $this->eclaims_caserate_list_id),
            'caserate' => $this->whenLoaded('caserate'),
            'pHospitalTransmittalNo' => $this->pHospitalTransmittalNo,
            'pTransmissionControlNumber' => $this->pTransmissionControlNumber,
            'pReceiptTicketNumber' => $this->pReceiptTicketNumber,
            'pClaimSeriesLhio' => $this->pClaimSeriesLhio,
            'pStatus' => $this->pStatus,
            'pTransmissionDate' => $this->pTransmissionDate,
            'pTransmissionTime' => $this->pTransmissionTime,
            'pCheckDate' => $this->pCheckDate,
            'isSuccess' => $this->isSuccess,
            'fail_error' => $this->fail_error,

            'patient' => $this->whenLoaded('patient')
        ];
    }
}
