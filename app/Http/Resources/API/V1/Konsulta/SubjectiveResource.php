<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

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
                'pIllnessHistory' => "",
                'pSignsSymptoms' => "",
                'pOtherComplaint' => "",
                'pPainSite' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
