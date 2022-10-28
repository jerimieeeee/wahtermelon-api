<?php

namespace App\Http\Resources\API\V1\Consultation;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultNotesFinalDxResource extends JsonResource
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
            'icd10_code' => $this->icd10_code,
            'fdx_remark' => $this->fdx_remark,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
