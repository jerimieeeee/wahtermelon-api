<?php

namespace App\Http\Resources\API\V1\PhilHealth;

use Illuminate\Http\Resources\Json\JsonResource;

class PhilhealthCredentialResource extends JsonResource
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
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'program_code' => $this->when(! $this->relationLoaded('program'), $this->program_code),
            'program' => $this->whenLoaded('program'),
            'facility_name' => $this->facility_name,
            'accreditation_number' => $this->accreditation_number,
            'pmcc_number' => $this->pmcc_number,
            'software_certification_id' => $this->software_certification_id,
            'cipher_key' => $this->cipher_key,
            'username' => $this->username,
            'password' => $this->password,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
