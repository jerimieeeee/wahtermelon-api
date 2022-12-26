<?php

namespace App\Http\Resources\API\V1\PhilHealth;

use Illuminate\Http\Resources\Json\JsonResource;

class GetTokenResource extends JsonResource
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
            'pUserName' => $this->username?? "",
            'pUserPassword' =>  $this->password?? "",
            'pSoftwareCertificationId' => $this->software_certification_id,
            'pHospitalCode' => $this->accreditation_number
        ];
    }
}
