<?php

namespace App\Http\Resources\API\V1\MaternalCare;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultMcPrenatalResource extends JsonResource
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
            'id' => $this->id,
            'patient_mc_id' => $this->when(! $this->relationLoaded('patientMc'), $this->patient_mc_id),
            'patient_mc' => new PatientMcResource($this->whenLoaded('patientMc')),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'prenatal_date' => $this->prenatal_date?->format('Y-m-d'),
            'aog_weeks' => $this->aog_weeks,
            'aog_days' => $this->aog_days,
            'trimester' => $this->trimester,
            'visit_sequence' => $this->visit_sequence,
            'patient_height' => $this->patient_height,
            'patient_weight' => $this->patient_weight,
            'bp_systolic' => $this->bp_systolic,
            'bp_diastolic' => $this->bp_diastolic,
            'fundic_height' => $this->fundic_height,
            'presentation_code' => $this->when(! $this->relationLoaded('presentation'), $this->presentation_code),
            'presentation' => $this->whenLoaded('presentation'),
            'fhr' => $this->fhr,
            'location_code' => $this->when(! $this->relationLoaded('location'), $this->location_code),
            'location' => $this->whenLoaded('location'),
            'private' => $this->private,
            'remarks' => $this->remarks,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
