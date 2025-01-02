<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibComprehensiveQuestionnaireResource extends JsonResource
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
            'lib_comprehensive_code' => $this->when(! $this->relationLoaded('comprehensive'), $this->lib_comprehensive_code),
            'comprehensive' => $this->whenLoaded('comprehensive'),
            'question' => $this->question,
            'sequence' => $this->sequence,
        ];
    }
}
