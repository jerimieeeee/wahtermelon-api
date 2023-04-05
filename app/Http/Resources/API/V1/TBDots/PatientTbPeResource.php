<?php

namespace App\Http\Resources\API\V1\TBDots;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientTbPeResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'user_id' => $this->user_id,
            'facility_code' => $this->facility_code,
            'abdomen' => $this->abdomen,
            'amuscles' => $this->amuscles,
            'bcg' => $this->bcg,
            'cardiovascular' => $this->cardiovascular,
            'endocrine' => $this->endocrine,
            'extremities' => $this->extremities,
            'ghealth' => $this->ghealth,
            'gurinary' => $this->gurinary,
            'lnodes' => $this->lnodes,
            'neurological' => $this->neurological,
            'oropharynx' => $this->oropharynx,
            'skin' => $this->skin,
            'thoraxlungs' => $this->thoraxlungs,
        ];
    }
}
