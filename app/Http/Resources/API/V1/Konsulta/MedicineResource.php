<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
                'pOtherMedicine'=> strtoupper($this->added_medicine?? ""),
                'pOthMedDrugGrouping'=> !empty($this->medicinePurpose) && Str::contains($this->medicinePurpose->desc, ['NCD', 'Antibiotic', 'Others'] ? strtoupper($this->medicinePurpose->desc) : ""),
                'pRoute' => "",
                'pQuantity' => !empty($this->dispensingLatest) ? $this->dispensing_sum_dispense_quantity : $this->quantity?? "",
                'pActualUnitPrice' => !empty($this->dispensingLatest) ? $this->dispensing_sum_unit_price : "",
                'pTotalAmtPrice' => !empty($this->dispensingLatest) ? $this->dispensing_sum_total_amount : "",
                'pInstructionQuantity' => !empty($this->id) ? $this->instruction_quantity?? "1" : "",
                'pInstructionStrength' => !empty($this->id) ? $this->dosage_quantity." ".strtoupper($this->dosage_uom) : "",
                'pInstructionFrequency' => $this->doseRegimen->desc?? "",
                'pPrescribingPhysician'=> !empty($this->id) ? strtoupper($this->prescribedBy->first_name. " " . $this->prescribedBy->last_name) : "",
                'pIsDispensed' => !empty($this->id) ? !empty($this->dispensingLatest) ? 'Y' : 'N' : "",
                'pDateDispensed' => !empty($this->dispensingLatest) ? $this->dispensingLatest->dispensing_date : "",
                'pDispensingPersonnel' => !empty($this->dispensingLatest) ? strtoupper($this->dispensingLatest->user->first_name. " " . $this->dispensingLatest->user->last_name) : "",
                'pIsApplicable' => !empty($this->id) ? 'Y' : 'N',
                'pDateAdded' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : "",
                'pReportStatus'=>"U",
                'pDeficiencyRemarks'=>""
            ]
        ];
    }
}
