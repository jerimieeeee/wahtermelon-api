<?php

namespace App\Http\Resources\API\V1\Consultation;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultNotesManagementResource extends JsonResource
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
            'notes_id' => $this->when(!$this->relationLoaded('consultNotes'),$this->consult_id),
            'consultNotes' => $this->whenLoaded('consultNotes'),
            'patient_id' => $this->when(!$this->relationLoaded('patient'),$this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(!$this->relationLoaded('user'),$this->user_id),
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(!$this->relationLoaded('facility'),$this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'management_code' => $this->when(!$this->relationLoaded('management'),$this->management_code),
            'management' => $this->whenLoaded('management'),
            'remarks' => $this->remarks,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
