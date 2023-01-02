<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibLaboratoryCategoryResource extends JsonResource
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
            'laboratory' => $this->when($this->relationLoaded('laboratory'), new LibLaboratoryResource($this->laboratory)),
            'field_name' => $this->field_name,
            'field_desc' => $this->field_desc,
            'group_cat' => $this->group_cat,
            'range_cat' => $this->range_cat,
            'nv_min' => $this->nv_min,
            'nv_max' => $this->nv_max,
            'nv_uom' => $this->nv_uom,
            'sequence_id' => $this->sequence_id,
            'field_active' => $this->field_active,
        ];
    }
}
