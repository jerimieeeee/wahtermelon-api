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
            'hci_fee' => $this->hci_fee,
            'prof_fee' => $this->prof_fee,
            'caserate_fee' => $this->caserate_fee,
            'caserate_attendant' => $this->caserate_attendant
        ];
    }
}
