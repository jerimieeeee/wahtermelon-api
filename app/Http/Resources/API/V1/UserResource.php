<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'suffix_name' => $this->suffix_name,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'contact_number' => $this->contact_number,
            'is_active' => $this->is_active,
            'photo_url' => $this->photo_url,
            'email' => $this->email,
            'accreditation_number' => $this->accreditation_number,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
