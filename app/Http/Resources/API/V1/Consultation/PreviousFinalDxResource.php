<?php

namespace App\Http\Resources\API\V1\Consultation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PreviousFinalDxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'prev_date' => $this->consult_date,
            'final_diagnosis' => $this->consultNotes
        ];
    }
}
