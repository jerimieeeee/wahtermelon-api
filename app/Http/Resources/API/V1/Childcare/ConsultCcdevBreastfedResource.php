<?php

namespace App\Http\Resources\API\V1\Childcare;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultCcdevBreastfedResource extends JsonResource
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
            'patient_ccdev_id' => $this->patient_ccdev_id,
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'bfed_month1' => $this->bfed_month1,
            'bfed_month2' => $this->bfed_month2,
            'bfed_month3' => $this->bfed_month3,
            'bfed_month4' => $this->bfed_month4,
            'bfed_month5' => $this->bfed_month5,
            'bfed_month6' => $this->bfed_month6,
            'reason_id' => $this->reason_id,
            'ebfreasons' => $this->ebfreasons,
            'ebf_date' => ! is_null($this->ebf_date) ? $this->ebf_date->format('Y-m-d') : null,
            'comp_fed_date' => $this->comp_fed_date,
            'deleted_at' => ! is_null($this->deleted_at) ? $this->deleted_at->format('Y-m-d H:i:s') : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
