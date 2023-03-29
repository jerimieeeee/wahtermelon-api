<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialHistoryResource extends JsonResource
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
                'pIsSmoker' => $this->smoking ?? '',
                'pNoCigpk' => $this->pack_per_year ?? '',
                'pIsAdrinker' => $this->alcohol ?? '',
                'pNoBottles' => $this->bottles_per_day ?? '',
                'pIllDrugUser' => $this->illicit_drugs ?? '',
                'pIsSexuallyActive' => $this->sexually_active ?? '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
