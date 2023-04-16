<?php

namespace App\Http\Resources\API\V1\Patient;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientMenstrualHistoryResource extends JsonResource
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
            'menarche' => $this->menarche,
            'lmp' => $this->lmp,
            'period_duration' => $this->period_duration,
            'cycle' => $this->cycle,
            'pads_per_day' => $this->pads_per_day,
            'onset_sexual_intercourse' => $this->onset_sexual_intercourse,
            'method' => $this->method,
            'fpMethod' => $this->whenLoaded('libFpMethod'),
            'menopause' => $this->menopause,
            'menopause_age' => $this->menopause_age,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
