<?php

namespace App\Http\Resources\API\V1\Adolescent;

use App\Http\Resources\API\V1\Libraries\LibRapidQuestionnaireResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultAsrhRapidAnswerResource extends JsonResource
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
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'consult_asrh_rapid_id' => $this->when(! $this->relationLoaded('consultRapid'), $this->consult_asrh_rapid_id),
            'consult_asrh_rapid' => $this->whenLoaded('consultRapid'),
            'lib_rapid_questionnaire_id' => $this->when(! $this->relationLoaded('question'), $this->lib_rapid_questionnaire_id),
            //'question' => LibRapidQuestionnaireResource::collection($this->whenLoaded('question')),
            'question' => $this->whenLoaded('question'),
            'answer' => $this->answer,
            'remarks' => $this->remarks,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
