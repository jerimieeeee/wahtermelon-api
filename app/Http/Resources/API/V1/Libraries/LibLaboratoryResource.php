<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibLaboratoryResource extends JsonResource
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
            'code' => $this->code,
            'desc' => $this->desc,
            'category' => $this->when($this->relationLoaded('category'), LibLaboratoryCategoryResource::collection($this->category)),
            'lab_active' => $this->lab_active,
            'konsulta_active' => $this->konsulta_active,
            'konsulta_lab_id' => $this->konsulta_lab_id,
        ];
    }
}
