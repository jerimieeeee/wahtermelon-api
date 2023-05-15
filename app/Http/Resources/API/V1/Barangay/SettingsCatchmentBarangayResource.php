<?php

namespace App\Http\Resources\API\V1\Barangay;

use App\Http\Resources\API\V1\PSGC\BarangayResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsCatchmentBarangayResource extends JsonResource
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
            'year' => $this->year,
            'barangay' => $this->when($this->barangay, new BarangayResource($this->barangay)),
            'population' => $this->population,
            'population_opt' => $this->population_opt,
            'population_wra' => $this->population_wra,
            'household' => $this->household,
            'zod' => $this->zod,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
