<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibDiagnosisResource extends JsonResource
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

            'class_id' => $this->class_id,
            'class_name' => $this->class_name,
            'icd10' => $this->icd10,
            'notifiable_flag' => $this->notifiable_flag,
            'morbidity_flag' => $this->morbidity_flag,
        ];
    }
}
