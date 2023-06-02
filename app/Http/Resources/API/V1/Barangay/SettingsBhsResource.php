<?php

namespace App\Http\Resources\API\V1\Barangay;

use App\Http\Resources\API\V1\PSGC\BarangayResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsBhsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'barangay' => $this->when($this->barangay, new BarangayResource($this->barangay)),
            'bhs_barangay' => SettingsCatchmentBarangayResource::collection($this->whenLoaded('bhsBarangay')),
            'assigned_user_id' => $this->when(! $this->relationLoaded('assignedUser'), $this->assigned_user_id),
            'assigned_user' => $this->whenLoaded('assignedUser'),
        ];
    }
}
