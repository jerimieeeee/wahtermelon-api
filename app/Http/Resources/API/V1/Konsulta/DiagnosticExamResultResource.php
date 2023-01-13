<?php

namespace App\Http\Resources\API\V1\Konsulta;

use App\Models\V1\Laboratory\ConsultLaboratory;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DiagnosticExamResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /*$enlistmentDate = Carbon::parse($this->patient->philhealthLatest->enlistment_date?? "")->format('Y-m-d');
        $requestDate = Carbon::parse($this->request_date?? "")->format('Y-m-d');*/
        $consultLaboratoryFBS = ConsultLaboratory::query()
            ->whereHas('fbs')
            ->where('lab_code', 'FBS')
            ->where('patient_id', $this->id?? "")
            ->where('request_date', $this->philhealthLatest->enlistment_date?? "")
            ->get();
        $consultLaboratoryRBS = ConsultLaboratory::query()
            ->whereHas('rbs')
            ->where('lab_code', 'RBS')
            ->where('patient_id', $this->id?? "")
            ->where('request_date', $this->philhealthLatest->enlistment_date?? "")
            ->get();
        //dump($consultLaboratoryFBS);
        //dump(count($consultLaboratoryFBS));
        $data = [
            '_attributes' => [
                'pHciCaseNo' => $this->case_number?? "",
                'pHciTransNo' => !empty($this->philhealthLatest->transaction_number) ? 'P'.$this->philhealthLatest->transaction_number?? "" : "",
                'pPatientPin' => $this->philhealthLatest->philhealth_id?? "",
                'pPatientType' => $this->philhealthLatest->membership_type_id?? "",
                'pMemPin' => !empty($this->philhealthLatest->membership_pin) ? $this->philhealthLatest->membership_pin : $this->philhealthLatest->philhealth_id?? "",
                'pEffYear' => $this->philhealthLatest->effectivity_year?? ""
            ],
            //'FBSS' => $this->when($consultLaboratoryFBS , ['FBS' => [LaboratoryFbsResource::collection(!empty($consultLaboratoryFBS) ? $consultLaboratoryFBS : [[]])->resolve()]]),
            //'FBSS' => $this->when(isset($this->fbs) , ['FBS' => [LaboratoryFbsResource::make(!empty($this->fbs) ? $this->fbs : [[]])->resolve()]]),
            //'RBSS' => $this->when(isset($this->rbs) , ['RBS' => [LaboratoryRbsResource::make(!empty($this->rbs) ? $this->rbs : [[]])->resolve()]])
        ];
        if(count($consultLaboratoryFBS)>0){
            $data['FBSS'] = ['FBS' => [LaboratoryFbsResource::collection(!empty($consultLaboratoryFBS) ? $consultLaboratoryFBS : [[]])->resolve()]];
        }
        if(count($consultLaboratoryRBS)>0){
            $data['RBSS'] = ['RBS' => [LaboratoryRbsResource::collection(!empty($consultLaboratoryRBS) ? $consultLaboratoryRBS : [[]])->resolve()]];
        }
        return $data;
    }
}
