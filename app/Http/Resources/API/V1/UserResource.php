<?php

namespace App\Http\Resources\API\V1;

use App\Http\Resources\API\V1\Libraries\LibDesignationResource;
use App\Http\Resources\API\V1\Libraries\LibEmployerResource;
use App\Http\Resources\API\V1\PSGC\FacilityResource;
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
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->when($this->relationLoaded('facility'), new FacilityResource($this->facility)),
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
            'designation_code' => $this->when(! $this->relationLoaded('designation'), $this->designation_code),
            'designation' => $this->when($this->relationLoaded('designation'), new LibDesignationResource($this->designation)),
            'employer_code' => $this->when(! $this->relationLoaded('employer'), $this->employer_code),
            'employer' => $this->when($this->relationLoaded('employer'), new LibEmployerResource($this->employer)),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
