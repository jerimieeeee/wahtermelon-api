<?php

namespace App\Http\Resources\API\V1\Adolescent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultAsrhRapidResource extends JsonResource
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
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'assessment_date' => $this->assessment_date?->format('Y-m-d'),
            'client_type' => $this->client_type,
            'lib_asrh_client_type_code' => $this->when(! $this->relationLoaded('clientType'), $this->lib_asrh_client_type_code),
            'lib_asrh_client_type' => $this->whenLoaded('clientType'),
            'other_client_type' => $this->other_client_type,
            'consent_flag' => $this->consent_flag,
            'notes' => $this->notes,
            'end_date' => $this->end_date?->format('Y-m-d'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
