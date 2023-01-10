<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class PhysicalExaminationSpecificResource extends JsonResource
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
                'pSkinRem' => strtoupper($this->skin_remarks?? ""),
                'pHeentRem' => strtoupper($this->heent_remarks?? ""),
                'pChestRem' => strtoupper($this->chest_remarks?? ""),
                'pHeartRem' => strtoupper($this->heart_remarks?? ""),
                'pAbdomenRem' => strtoupper($this->abdomen_remarks?? ""),
                'pNeuroRem' => strtoupper($this->neuro_remarks?? ""),
                'pRectalRem' => strtoupper($this->rectal_remarks?? ""),
                'pGuRem' => strtoupper($this->genitourinary_remarks?? ""),
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
