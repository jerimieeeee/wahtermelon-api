<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class ImmunizationPregnantWomenResource extends JsonResource
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
                'pChildImmcode' => '',
                'pYoungwImmcode' => '',
                'pPregwImmcode' => ! empty($this->pregnant_women_vaccine) ? $this->pregnant_women_vaccine : '999',
                'pElderlyImmcode' => '',
                'pOtherImm' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
