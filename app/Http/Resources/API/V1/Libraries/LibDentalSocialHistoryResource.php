<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibDentalSocialHistoryResource extends JsonResource
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
            'column_name' => $this->column_name,
            'desc' => $this->desc
        ];
    }
}
