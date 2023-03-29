<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class ImmunizationElderlyResource extends JsonResource
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
                'pPregwImmcode' => '',
                'pElderlyImmcode' => ! empty($this->elderly_vaccine) ? $this->elderly_vaccine : '999',
                'pOtherImm' => '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
