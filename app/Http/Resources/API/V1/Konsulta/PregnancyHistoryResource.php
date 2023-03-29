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
                'pPregCnt' => $this->gravidity ?? '',
                'pDeliveryCnt' => $this->parity ?? '',
                'pDeliveryTyp' => $this->delivery_type ?? '',
                'pFullTermCnt' => $this->full_term ?? '',
                'pPrematureCnt' => $this->preterm ?? '',
                'pAbortionCnt' => $this->abortion ?? '',
                'pLivChildrenCnt' => $this->livebirths ?? '',
                'pWPregIndhyp' => $this->induced_hypertension ?? '',
                'pWFamPlan' => $this->with_family_planning ?? 'N',
                'pIsApplicable' => ! empty($this->id) ? 'Y' : 'N',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
