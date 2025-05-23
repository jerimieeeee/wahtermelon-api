<?php

namespace App\Http\Resources\API\V1\Household;

use App\Http\Resources\API\V1\Libraries\LibResidenceClassificationResource;
use App\Http\Resources\API\V1\PSGC\BarangayAddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HouseholdFolderResource extends JsonResource
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
            'address' => $this->address,
            'barangay_code' => $this->when(! $this->relationLoaded('barangay'), $this->barangay_code),
            'barangay' => $this->when($this->relationLoaded('barangay'), new BarangayAddressResource($this->barangay)),
            'residence_classification_code' => $this->when(! $this->relationLoaded('residenceClassification'), $this->residence_classification_code),
            'residence_classification' => $this->when($this->relationLoaded('residenceClassification'), new LibResidenceClassificationResource($this->residenceClassification)),
            'cct_date' => $this->cct_date?->format('Y-m-d'),
            'cct_id' => $this->cct_id,
            'environmentalLatest' => $this->whenLoaded('environmentalLatest'),
            'household_member' => $this->when($this->relationLoaded('householdMember'), HouseholdMemberResource::collection($this->householdMember)),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
