<?php

namespace App\Http\Resources\API\V1\Childcare;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultCcdevServicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return [
        //     'notes_id' => $this->notes_id,
        //     'consult_id' => $this->consult_id,
        //     'patient_id' => $this->patient_id,
        //     'user_id' => $this->user_id,
        //     'complaint_id' => $this->complaint_id,
        //     'complaint_date' => $this->complaint_date?->format('Y-m-d'),
        //     'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        //     'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        // ];
    }
}
