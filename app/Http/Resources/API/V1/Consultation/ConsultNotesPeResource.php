<?php

namespace App\Http\Resources\API\V1\Consultation;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultNotesPeResource extends JsonResource
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
            'notes_id' => $this->notes_id,
            'user_id' => $this->user_id,
            'remarks' => $this->remarks,
            'breast_screen' => $this->breast_screen,
            'breast_remarks' => $this->breast_remarks,
            'skin_code' => $this->skin_code,
            'heent_code' => $this->heent_code,
            'heent_remarks' => $this->heent_remarks,
            'chest_code' => $this->chest_code,
            'chest_remarks' => $this->chest_remarks,
            'heart_code' => $this->heart_code,
            'heart_remarks' => $this->heart_remarks,
            'abdomen_code' => $this->abdomen_code,
            'abdome_remarks' => $this->abdome_remarks,
            'extremities_code' => $this->extremities_code,
            'extremities_remarks' => $this->extremities_remarks,
        ];
    }
}
