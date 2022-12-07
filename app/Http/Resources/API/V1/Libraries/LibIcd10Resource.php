<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibIcd10Resource extends JsonResource
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

            'icd10_code' => $this->icd10_code,
            'icd10_desc' => $this->icd10_desc,
            'notifiable_cat' => $this->notifiable_cat,
            'notifiable_name' => $this->notifiable_name,
            'is_morbidity' => $this->is_morbidity,
        ];
    }
}
