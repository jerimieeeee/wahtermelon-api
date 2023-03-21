<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class DiagnosticResource extends JsonResource
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
                'pDiagnosticId' => !empty($this->id) && !empty($this->laboratory->konsulta_lab_id) ? $this->laboratory->konsulta_lab_id : (!empty($this->id) && empty($this->laboratory->konsulta_lab_id) ? 0 : ""),
                'pOthRemarks' => !empty($this->id) && empty($this->laboratory->konsulta_lab_id) ? strtoupper($this->laboratory->desc) : "",
                'pIsPhysicianRecommendation' => $this->recommendation_code?? "",
                'pPatientRemarks' => $this->request_status_code?? "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
