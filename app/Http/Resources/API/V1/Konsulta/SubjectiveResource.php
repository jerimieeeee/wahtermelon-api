<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class SubjectiveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            '_attributes' => [
                'pIllnessHistory' => strtoupper($this->history?? ""),
                'pSignsSymptoms' => $this->konsulta_complaint_id?? "",
                'pOtherComplaint' => !empty($this->konsulta_complaint_id) && Str::contains($this->konsulta_complaint_id, ['X']) ? strtoupper($this->complaint?? "") : "",
                'pPainSite' => strtoupper($this->complaint_desc?? ""),
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
