<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibComprehensiveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'desc' => $this->desc,
            'instruction' => $this->instruction,
            'sequence' => $this->sequence,
        ];
    }
}
