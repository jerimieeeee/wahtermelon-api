<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class PhysicalExaminationMiscResource extends JsonResource
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
                'pSkinId' => $this->skin ?? '',
                'pHeentId' => $this->heent ?? '',
                'pChestId' => $this->chest ?? '',
                'pHeartId' => $this->heart ?? '',
                'pAbdomenId' => $this->abdomen ?? '',
                'pNeuroId' => $this->neuro ?? '',
                'pRectalId' => $this->rectal ?? '',
                'pGuId' => $this->genitourinary ?? '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
