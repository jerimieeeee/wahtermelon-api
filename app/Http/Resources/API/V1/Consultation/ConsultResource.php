<?php

namespace App\Http\Resources\API\V1\Consultation;

use App\Http\Resources\API\V1\Patient\PatientVitalsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultResource extends JsonResource
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
            'patient_id' => $this->when(!$this->relationLoaded('patient'),$this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(!$this->relationLoaded('user'),$this->user_id),
            'user' => $this->whenLoaded('user'),
            'consult_date' => $this->consult_date->format('Y-m-d H:i:s'),
            'physician_id' => $this->when(!$this->relationLoaded('physician'),$this->physician_id),
            'physician' => $this->whenLoaded('physician'),
            'vitals' => $this->when($this->relationLoaded('vitals'), PatientVitalsResource::collection($this->vitals)),
            'is_pregnant' => $this->is_pregnant,
            'consult_done' => $this->consult_done,
            'pt_group' => $this->pt_group,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
