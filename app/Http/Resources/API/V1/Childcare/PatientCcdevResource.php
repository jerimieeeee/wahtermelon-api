<?php

namespace App\Http\Resources\API\V1\Childcare;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientCcdevResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'birth_weight' => $this->birth_weight,
            'mothers_id' => $this->mothers_id,
            'ccdev_ended' => $this->ccdev_ended,
            'admission_date' => ! is_null($this->admission_date) ? $this->admission_date->format('Y-m-d H:i:s') : null,
            'discharge_date' => ! is_null($this->discharge_date) ? $this->discharge_date->format('Y-m-d H:i:s') : null,
            'nbs_filter' => $this->nbs_filter,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
