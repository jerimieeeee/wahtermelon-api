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
                'pSkinRem' => $this->skin_remarks?? "",
                'pHeentRem' => $this->heent_remarks?? "",
                'pChestRem' => $this->chest_remarks?? "",
                'pHeartRem' => $this->heart_remarks?? "",
                'pAbdomenRem' => $this->abdomen_remarks?? "",
                'pNeuroRem' => $this->neuro_remarks?? "",
                'pRectalRem' => $this->rectal_remarks?? "",
                'pGuRem' => $this->genitourinary_remarks?? "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
