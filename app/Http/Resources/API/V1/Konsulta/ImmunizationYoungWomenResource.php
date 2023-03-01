<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class ImmunizationYoungWomenResource extends JsonResource
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
                'pChildImmcode' => "",
                'pYoungwImmcode' => !empty($this->young_women_vaccine) ? $this->young_women_vaccine : "999",
                'pPregwImmcode' => "",
                'pElderlyImmcode' => "",
                'pOtherImm' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
