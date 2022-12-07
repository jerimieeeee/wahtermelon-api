<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibEbfReasonResource extends JsonResource
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

            'reason_id' => $this->reason_id,
            'desc' => $this->desc,

        ];
    }
}
