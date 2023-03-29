<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class MenstrualHistoryResource extends JsonResource
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
                'pMenarchePeriod' => $this->menarche ?? '',
                'pLastMensPeriod' => $this->lmp ?? '',
                'pPeriodDuration' => $this->period_duration ?? '',
                'pMensInterval' => $this->cycle ?? '',
                'pPadsPerDay' => $this->pads_per_day ?? '',
                'pOnsetSexIc' => $this->onset_sexual_intercourse ?? '',
                'pBirthCtrlMethod' => $this->method ?? '',
                'pIsMenopause' => ! empty($this->id) ? $this->menopause ? 'Y' : 'N' : '',
                'pMenopauseAge' => ! empty($this->menopause) ? $this->menopause_age : '',
                'pIsApplicable' => ! empty($this->id) ? 'Y' : 'N',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
        ];
    }
}
