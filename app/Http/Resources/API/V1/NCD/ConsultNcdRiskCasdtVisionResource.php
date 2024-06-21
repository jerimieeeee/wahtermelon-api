<?php

namespace App\Http\Resources\API\V1\NCD;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultNcdRiskCasdtVisionResource extends JsonResource
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
            'consult_ncd_risk_id' => $this->consult_ncd_risk_id,
            'patient_ncd_id' => $this->patient_ncd_id,
            'consult_id' => $this->consult_id,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'eye_complaint' => $this->when(! $this->relationLoaded('consult'), $this->eye_complaint),
            'eye_refer' => $this->when(! $this->relationLoaded('refer'), $this->eye_refer),
            'unaided' => $this->when(! $this->relationLoaded('unaided'), $this->unaided),
            'pinhole' => $this->when(! $this->relationLoaded('pinhole'), $this->pinhole),
            'improved' => $this->when(! $this->relationLoaded('improved'), $this->improved),
            'aided' => $this->when(! $this->relationLoaded('aided'), $this->aided),
            'eye_refer_prof' => $this->when(! $this->relationLoaded('referProf'), $this->eye_refer_prof),
            'deleted_at' => ! is_null($this->deleted_at) ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
