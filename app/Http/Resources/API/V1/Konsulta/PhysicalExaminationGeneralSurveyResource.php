<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class PhysicalExaminationGeneralSurveyResource extends JsonResource
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
                'pGenSurveyId' => "",
                'pGenSurveyRem' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
