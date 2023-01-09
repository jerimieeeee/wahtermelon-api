<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
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
                'pHciTransNo'=> $this->consult->transaction_number?? "",
                'pCategory'=> $this->konsultaMedicine->category?? "",
                'pDrugCode'=> $this->konsultaMedicine->code?? "",
                'pGenericCode'=> $this->konsultaMedicine->generic_code?? "",
                'pSaltCode'=> $this->konsultaMedicine->salt_code?? "",
                'pStrengthCode'=> $this->konsultaMedicine->strength_code?? "",
                'pFormCode'=> $this->konsultaMedicine->form_code?? "",
                'pUnitCode'=> $this->konsultaMedicine->unit_code?? "",
                'pPackageCode'=> $this->konsultaMedicine->package_code?? "",
                'pOtherMedicine'=> $this->added_medicine,
                'pRoute' => "",
                'pQuantity' => $this->quantity?? "",
                'pActualUnitPrice' => "",
                'pTotalAmtPrice' => "",
                'pInstructionQuantity'=>"",
                'pInstructionStrength'=>"",
                'pInstructionFrequency'=>"",
                'pPrescribingPhysician'=>"",
                'pIsDispensed'=>"",
                'pDateDispensed'=>"",
                'pDispensingPersonnel'=>"",
                'pIsApplicable'=>"",
                'pDateAdded'=>"",
                'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
            ]
        ];
    }
}
