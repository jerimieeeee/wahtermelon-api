<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibCcdevServiceResource extends JsonResource
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
            'service_id' => $this->service_id,
            'service_name' => $this->service_name,
            'order_seq' => $this->order_seq,
            'service_cat' => $this->service_cat,
        ];
    }
}
