<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibAsrhAlgorithmResource extends JsonResource
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
            'ask_instruction' => $this->ask_instruction,
            'sequence' => $this->sequence,
        ];
    }
}
