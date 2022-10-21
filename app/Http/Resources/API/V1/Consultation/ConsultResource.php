<?php

namespace App\Http\Resources\API\V1\Consultation;

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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'physician_id' => $this->physician_id,
            'is_pregnant' => $this->is_pregnant,
            'pt_group' => $this->pt_group,
        ];
    }
}
