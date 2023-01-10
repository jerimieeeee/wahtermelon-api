<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibPeResource extends JsonResource
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

            'category_id' => $this->category_id,
            'pe_id' => $this->pe_id,
            'pe_desc' => $this->pe_desc,
            'konsulta_pe_id' => $this->konsulta_pe_id,
            'konsulta_library_status' => $this->konsulta_library_status,
            'modules' => $this->modules,
        ];
    }
}
