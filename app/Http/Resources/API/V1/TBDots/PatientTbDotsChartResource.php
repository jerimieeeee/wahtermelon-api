<?php

namespace App\Http\Resources\API\V1\TBDots;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientTbDotsChartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'dots_date' => $this->dots_date,
            'dots_type' => $this->dots_type
        ];
    }
}
