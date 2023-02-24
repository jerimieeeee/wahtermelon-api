<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class NoMedicineResource extends JsonResource
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
                'pHciCaseNo'=> $this->patient->case_number?? "",
                'pHciTransNo'=> !empty($this->id) ? 'S'.$this->transaction_number : "",
                'pCategory'=> "",
                'pDrugCode'=> "NOMED0000000000000000000000000",
                'pGenericCode'=> "NOMED",
                'pSaltCode'=> "00000",
                'pStrengthCode'=> "00000",
                'pFormCode'=> "00000",
                'pUnitCode'=> "00000",
                'pPackageCode'=> "00000",
                'pOtherMedicine'=> "",
                'pOthMedDrugGrouping'=> "",
                'pRoute' => "",
                'pQuantity' => "",
                'pActualUnitPrice' => "",
                'pTotalAmtPrice' => "",
                'pInstructionQuantity' => "",
                'pInstructionStrength' => "",
                'pInstructionFrequency' => "",
                'pPrescribingPhysician'=> "",
                'pIsDispensed' => "N",
                'pDateDispensed' => "",
                'pDispensingPersonnel' => "",
                'pIsApplicable' => 'N',
                'pDateAdded' => "",
                'pReportStatus'=>"U",
                'pDeficiencyRemarks'=>""
            ]
        ];
    }
}
