<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class PregnancyHistoryResource extends JsonResource
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
                'pPregCnt' => "",
                'pDeliveryCnt' => "",
                'pDeliveryTyp' => "",
                'pFullTermCnt' => "",
                'pPrematureCnt' => "",
                'pAbortionCnt' => "",
                'pLivChildrenCnt' => "",
                'pWPregIndhyp' => "",
                'pWFamPlan' => "N",
                'pIsApplicable' => "N",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
