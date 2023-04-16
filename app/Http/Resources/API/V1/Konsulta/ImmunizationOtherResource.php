<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class ImmunizationOtherResource extends JsonResource
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
                'pElderlyImmcode' => '',
                'pOtherImm' => ! empty($this->vaccines) ? strtoupper($this->vaccines->vaccine_desc) : '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
