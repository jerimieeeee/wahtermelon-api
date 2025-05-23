<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibComplaintResource extends JsonResource
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

            'complaint_id' => $this->complaint_id,
            'complaint_desc' => $this->complaint_desc,
            'complaint_active' => $this->complaint_active,
            'konsulta_complaint_id' => $this->konsulta_complaint_id,
            'konsulta_library_status' => $this->konsulta_library_status,
            'gbv_library_status' => $this->gbv_library_status,
        ];
    }
}
