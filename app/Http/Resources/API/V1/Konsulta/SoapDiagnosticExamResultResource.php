<?php

namespace App\Http\Resources\API\V1\Konsulta;

use App\Models\V1\Laboratory\ConsultLaboratory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class SoapDiagnosticExamResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /*$data = [
            '_attributes' => [
                'pHciCaseNo' => $this->patient->case_number?? "",
                'pHciTransNo' => $this->consult->transaction_number?? "",
                'pPatientPin' => $this->patient->philhealthLatest->philhealth_id?? "",
                'pPatientType' => $this->patient->philhealthLatest->membership_type_id?? "",
                'pMemPin' => $this->patient->philhealthLatest->member_pin?? "",
                'pEffYear' => $this->patient->philhealthLatest->effectivity_year?? ""
            ],
        ];

        if(!empty($this->cbc)){
            $data['CBCS'] = ['CBC' => [LaboratoryCbcResource::make($this->cbc)->resolve()]];
        }
        if(!empty($this->urinalysis)){
            $data['URINALYSISS'] = ['URINALYSIS' => [LaboratoryUrinalysisResource::make($this->urinalysis)->resolve()]];
        }
        return $data;*/
        $cbc = ConsultLaboratory::query()
            ->whereHas('cbc')
            ->where('lab_code', 'CBC')
            ->where('consult_id', $this->id?? "")
            ->get();
        $urinalysis = ConsultLaboratory::query()
            ->whereHas('urinalysis')
            ->where('lab_code', 'URN')
            ->where('consult_id', $this->id?? "")
            ->get();
        $chest = ConsultLaboratory::query()
            ->whereHas('chestXray')
            ->where('lab_code', 'CXRAY')
            ->where('consult_id', $this->id?? "")
            ->get();
        $sputum = ConsultLaboratory::query()
            ->whereHas('sputum')
            ->where('lab_code', 'SPTM')
            ->where('consult_id', $this->id?? "")
            ->get();
        $lipid = ConsultLaboratory::query()
            ->whereHas('lipiProfile')
            ->where('lab_code', 'LPFL')
            ->where('consult_id', $this->id?? "")
            ->get();
        $fbs = ConsultLaboratory::query()
            ->whereHas('fbs')
            ->where('lab_code', 'FBS')
            ->where('consult_id', $this->id?? "")
            ->get();
        $rbs = ConsultLaboratory::query()
            ->whereHas('rbs')
            ->where('lab_code', 'RBS')
            ->where('consult_id', $this->id?? "")
            ->get();
        $ecg = ConsultLaboratory::query()
            ->whereHas('ecg')
            ->where('lab_code', 'ECG')
            ->where('consult_id', $this->id?? "")
            ->get();
        $fecalysis = ConsultLaboratory::query()
            ->whereHas('fecalysis')
            ->where('lab_code', 'FCAL')
            ->where('consult_id', $this->id?? "")
            ->get();
        $papsmear = ConsultLaboratory::query()
            ->whereHas('papsmear')
            ->where('lab_code', 'PSMR')
            ->where('consult_id', $this->id?? "")
            ->get();
        $ogtt = ConsultLaboratory::query()
            ->whereHas('oralGlucose')
            ->where('lab_code', 'OGTT')
            ->where('consult_id', $this->id?? "")
            ->get();
        $fobt = ConsultLaboratory::query()
            ->whereHas('fecalOccult')
            ->where('lab_code', 'FOBT')
            ->where('consult_id', $this->id?? "")
            ->get();
        $creatinine = ConsultLaboratory::query()
            ->whereHas('creatinine')
            ->where('lab_code', 'CRTN')
            ->where('consult_id', $this->id?? "")
            ->get();
        $ppd = ConsultLaboratory::query()
            ->whereHas('ppd')
            ->where('lab_code', 'PPD')
            ->where('consult_id', $this->id?? "")
            ->get();
        $hba1c = ConsultLaboratory::query()
            ->whereHas('hba1c')
            ->where('lab_code', 'HBA')
            ->where('consult_id', $this->id?? "")
            ->get();

        //Other Diagnostic Exam
        $gramStain = ConsultLaboratory::query()
            ->selectRaw("*, 'gramStain' AS lab")
            ->whereHas('gramStain')
            ->where('lab_code', 'GRMS')
            ->where('consult_id', $this->id?? "")
            ->get();

        $microscopy = ConsultLaboratory::query()
            ->selectRaw("*, 'microscopy' AS lab")
            ->whereHas('microscopy')
            ->where('lab_code', 'MCRP')
            ->where('consult_id', $this->id?? "")
            ->get();

        $data = [
            '_attributes' => [
                'pHciCaseNo' => $this->patient->case_number?? "",
                'pHciTransNo' => !empty($this->transaction_number) ? 'S'.$this->transaction_number : "",
                'pPatientPin' => $this->patient->philhealthLatest->philhealth_id?? "",
                'pPatientType' => $this->patient->philhealthLatest->membership_type_id?? "",
                'pMemPin' => !empty($this->patient->philhealthLatest->membership_pin) ? $this->patient->philhealthLatest->membership_pin : $this->patient->philhealthLatest->philhealth_id?? "",
                'pEffYear' => $this->patient->philhealthLatest->effectivity_year?? ""
            ],
        ];

        if(count($cbc)>0){
            $data['CBCS'] = ['CBC' => [LaboratoryCbcResource::collection(!empty($cbc) ? $cbc : [[]])->resolve()]];
        }
        if(count($urinalysis)>0){
            $data['URINALYSISS'] = ['URINALYSIS' => [LaboratoryUrinalysisResource::collection(!empty($urinalysis) ? $urinalysis : [[]])->resolve()]];
        }
        if(count($chest)>0){
            $data['CHESTXRAYS'] = ['CHESTXRAY' => [LaboratoryChestXrayResource::collection(!empty($chest) ? $chest : [[]])->resolve()]];
        }
        if(count($sputum)>0){
            $data['SPUTUMS'] = ['SPUTUM' => [LaboratorySputumResource::collection(!empty($sputum) ? $sputum : [[]])->resolve()]];
        }
        if(count($lipid)>0){
            $data['LIPIDPROFILES'] = ['LIPIDPROFILE' => [LaboratoryLipidProfileResource::collection(!empty($lipid) ? $lipid : [[]])->resolve()]];
        }
        if(count($fbs)>0){
            $data['FBSS'] = ['FBS' => [LaboratoryFbsResource::collection(!empty($fbs) ? $fbs : [[]])->resolve()]];
        }
        if(count($rbs)>0){
            $data['RBSS'] = ['RBS' => [LaboratoryRbsResource::collection(!empty($rbs) ? $rbs : [[]])->resolve()]];
        }
        if(count($ecg)>0){
            $data['ECGS'] = ['ECG' => [LaboratoryEcgResource::collection(!empty($ecg) ? $ecg : [[]])->resolve()]];
        }
        if(count($fecalysis)>0){
            $data['FECALYSISS'] = ['FECALYSIS' => [LaboratoryFecalysisResource::collection(!empty($fecalysis) ? $fecalysis : [[]])->resolve()]];
        }
        if(count($papsmear)>0){
            $data['PAPSMEARS'] = ['PAPSMEAR' => [LaboratoryPapSmearResource::collection(!empty($papsmear) ? $papsmear : [[]])->resolve()]];
        }
        if(count($ogtt)>0){
            $data['OGTTS'] = ['OGTT' => [LaboratoryOralGlucoseResource::collection(!empty($ogtt) ? $ogtt : [[]])->resolve()]];
        }
        if(count($fobt)>0){
            $data['FOBTS'] = ['FOBT' => [LaboratoryFecalOccultResource::collection(!empty($fobt) ? $fobt : [[]])->resolve()]];
        }
        if(count($creatinine)>0){
            $data['CREATININES'] = ['CREATININE' => [LaboratoryCreatinineResource::collection(!empty($creatinine) ? $creatinine : [[]])->resolve()]];
        }
        if(count($ppd)>0){
            $data['PPDTests'] = ['PPDTest' => [LaboratoryPpdResource::collection(!empty($ppd) ? $ppd : [[]])->resolve()]];
        }
        if(count($hba1c)>0){
            $data['HbA1cs'] = ['HbA1c' => [LaboratoryHba1cResource::collection(!empty($hba1c) ? $hba1c : [[]])->resolve()]];
        }

        //Other Diagnostic Exam
        $data['OTHERDIAGEXAMS'] = ['OTHERDIAGEXAM' => []];
        if(count($gramStain)>0){
            //$data['OTHERDIAGEXAMS'] = ['OTHERDIAGEXAM' => [OtherDiagnosticExamResource::collection(!empty($gramStain) ? $gramStain : [[]])->resolve()]];
            array_push($data['OTHERDIAGEXAMS']['OTHERDIAGEXAM'], [OtherDiagnosticExamResource::collection(!empty($gramStain) ? $gramStain : [[]])->resolve()]);
        }

        if(count($microscopy)>0){
            //$data['OTHERDIAGEXAMS'] = ['OTHERDIAGEXAM' => [OtherDiagnosticExamResource::collection(!empty($gramStain) ? $gramStain : [[]])->resolve()]];
            array_push($data['OTHERDIAGEXAMS']['OTHERDIAGEXAM'], [OtherDiagnosticExamResource::collection(!empty($microscopy) ? $microscopy : [[]])->resolve()]);
        }

        if(isNull($gramStain) && isNull($microscopy)) {
            unset($data['OTHERDIAGEXAMS']);
        }
        return $data;
    }
}
