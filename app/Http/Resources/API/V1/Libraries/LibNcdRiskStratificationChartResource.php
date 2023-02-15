<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibNcdRiskStratificationChartResource extends JsonResource
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
            'gender' => $this->gender,
            'age' => $this->age,
            'sbp' => $this->sbp,
            'cholesterol' => $this->cholesterol,
            'diabetes_present' => $this->diabetes_present,
            'type' => $this->type,
            'color' => $this->color,
        ];
    }
}
