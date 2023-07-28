<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibFpMethodResource extends JsonResource
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
            'gender' => $this->gender,
            'fhsis_code' => $this->fhsis_code,
            'unit' => $this->unit,
        ];
    }
}
