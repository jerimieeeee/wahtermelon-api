<?php

namespace App\Http\Resources\API\V1\Konsulta;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\PatientVitals;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $vitals = PatientVitals::wherePatientId($this->id?? "")->whereRaw("DATE_FORMAT(vitals_date, '%Y-%m-%d') = ?", $this->philhealthLatest->enlistment_date?? "")->first();
        $physicalExam = Consult::query()
            ->selectRaw("
                consults.patient_id, consult_notes.id, consult_date,
                GROUP_CONCAT(CASE
                    WHEN category_id = 'SKIN'
                    THEN konsulta_pe_id
                END) as skin,
                GROUP_CONCAT(CASE
                    WHEN category_id = 'HEENT'
                    THEN konsulta_pe_id
                END) as heent,
                GROUP_CONCAT(CASE
                    WHEN category_id = 'CHEST'
                    THEN konsulta_pe_id
                END) as chest,
                GROUP_CONCAT(CASE
                    WHEN category_id = 'HEART'
                    THEN konsulta_pe_id
                END) as heart,
                GROUP_CONCAT(CASE
                    WHEN category_id = 'ABDOMEN'
                    THEN konsulta_pe_id
                END) as abdomen,
                GROUP_CONCAT(CASE
                    WHEN category_id = 'NEURO'
                    THEN konsulta_pe_id
                END) as neuro,
                GROUP_CONCAT(CASE
                    WHEN category_id = 'RECTAL'
                    THEN konsulta_pe_id
                END) as rectal,
                GROUP_CONCAT(CASE
                    WHEN category_id = 'GENITOURINARY'
                    THEN konsulta_pe_id
                END) as genitourinary
            ")
            ->join('consult_notes', fn($join) => $join->on('consults.id', '=', 'consult_notes.consult_id')->select('notes_id', 'consult_id'))
            ->join('consult_notes_pes', fn($join) => $join->on('consult_notes.id', '=', 'consult_notes_pes.notes_id')->select('notes_id', 'pe_id'))
            ->join('lib_pes', fn($join) => $join->on('lib_pes.pe_id', '=', 'consult_notes_pes.pe_id')->select('pe_id', 'category_id', 'konsulta_pe_id'))
            ->whereRaw('!ISNULL(konsulta_pe_id) AND consults.patient_id = ? AND DATE_FORMAT(consult_date, "%Y-%m-%d") = ?', [$this->id?? "", $this->philhealthLatest->enlistment_date?? ""])
            ->groupByRaw('consult_notes.id, consult_notes_pes.pe_id')
            ->get();
        $physicalExamSpecific = Consult::query()
            ->join('consult_notes', fn($join) => $join->on('consults.id', '=', 'consult_notes.consult_id')->select('notes_id', 'consult_id'))
            ->join('consult_pe_remarks', fn($join) => $join->on('consult_notes.id', '=', 'consult_pe_remarks.notes_id'))
            ->whereRaw('consults.patient_id = ? AND DATE_FORMAT(consult_date, "%Y-%m-%d") = ?', [$this->id?? "", $this->philhealthLatest->enlistment_date?? ""])
            ->first();
        $genSurvey = Consult::query()
            ->join('consult_notes', fn($join) => $join->on('consults.id', '=', 'consult_notes.consult_id')->select('notes_id', 'consult_id'))
            ->whereRaw('consults.patient_id = ? AND DATE_FORMAT(consult_date, "%Y-%m-%d") = ?', [$this->id?? "", $this->philhealthLatest->enlistment_date?? ""])
            ->first();

        return [
            '_attributes' => [
                'pHciTransNo' => !empty($this->philhealthLatest->transaction_number) ? 'P'.$this->philhealthLatest->transaction_number : "",
                'pHciCaseNo' => $this->case_number?? "",
                'pProfDate' => $this->philhealthLatest->enlistment_date?? "",
                'pPatientPin' => $this->philhealthLatest->philhealth_id?? "",
                'pPatientType' => $this->philhealthLatest->membership_type_id?? "",
                'pPatientAge' => !empty($this->birthdate) ? Carbon::parse($this->birthdate)->diff($this->philhealthLatest->enlistment_date??"")->y . " YR(S), " .  Carbon::parse($this->birthdate)->diff($this->philhealthLatest->enlistment_date??"")->m . " MO(S), " . Carbon::parse($this->birthdate)->diff($this->philhealthLatest->enlistment_date??"")->d . " DAY(S)": "",
                'pMemPin' => !empty($this->philhealthLatest->member_pin) ? $this->philhealthLatest->member_pin : $this->philhealthLatest->philhealth_id?? "",
                'pEffYear' => $this->philhealthLatest->effectivity_year?? "",
                'pATC' => $this->philhealthLatest->authorization_transaction_code?? "WALKEDIN",
                'pIsWalkedIn' => !empty($this->philhealthLatest) ? $this->philhealthLatest->authorization_transaction_code == 'WALKEDIN' ? "Y" : "N" : "",
                'pTransDate' => isset($this->philhealthLatest->created_at) ? $this->philhealthLatest->created_at->format('Y-m-d') : "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ],
            'MEDHISTS' => [
                'MEDHIST' => [MedicalHistoryResource::collection(!empty($this->patientHistory) ? $this->patientHistory->whenEmpty(fn() => [[]]) : [[]])->resolve()],
            ],
            'MHSPECIFICS' => [
                'MHSPECIFIC' => [MedicalHistorySpecificResource::collection(!empty($this->patientHistorySpecifics) ? $this->patientHistorySpecifics->whenEmpty(fn() => [[]]) : [[]])->resolve()],
            ],
            'SURGHISTS' => [
                'SURGHIST' => [SurgicalHistoryResource::collection(!empty($this->surgicalHistory) ? $this->surgicalHistory->whenEmpty(fn() => [[]]) : [[]])->resolve()]
            ],
            'FAMHISTS' => [
                'FAMHIST' => [MedicalHistoryResource::collection(!empty($this->familyHistory) ? $this->familyHistory->whenEmpty(fn() => [[]]) : [[]])->resolve()]
            ],
            'FHSPECIFICS' => [
                'FHSPECIFIC' => [MedicalHistorySpecificResource::collection(!empty($this->familyHistorySpecifics) ? $this->familyHistorySpecifics->whenEmpty(fn() => [[]]) : [[]])->resolve()]
            ],
            'SOCHIST' => [SocialHistoryResource::make(!empty($this->socialHistory) ? $this->socialHistory : [[]])->resolve()],
            'IMMUNIZATIONS' => [
                'IMMUNIZATION' => [ImmunizationResource::collection(!empty($this->immunization) ? $this->immunization->whenEmpty(fn() => [[]]) : [[]])->resolve()]
            ],
            'MENSHIST' => [MenstrualHistoryResource::make(!empty($this->menstrualHistory) ? $this->menstrualHistory : [[]])->resolve()],
            'PREGHIST' => [PregnancyHistoryResource::make(!empty($this->pregnancyHistory) ? $this->pregnancyHistory : [[]])->resolve()],
            'PEPERT' => [PhysicalExaminationVitalsResource::make(!empty($vitals) ? $vitals : [[]])->resolve()],
            'BLOODTYPE' => [
                '_attributes' => [

                    'pBloodType'=>$this->blood_type_code?? "",
                    'pReportStatus'=>"U",
                    'pDeficiencyRemarks'=>""
                ]
            ],
            'PEGENSURVEY' => [PhysicalExaminationGeneralSurveyResource::make(!empty($genSurvey) ? $genSurvey : [[]])->resolve()],
            'PEMISCS' => [
                'PEMISC' => [PhysicalExaminationMiscResource::collection(!empty($physicalExam) ? $physicalExam->whenEmpty(fn() => [[]]) : [[]])->resolve()],
            ],
            'PESPECIFIC' => [PhysicalExaminationSpecificResource::make(!empty($physicalExamSpecific) ? $physicalExamSpecific : [[]])->resolve()],
            'NCDQANS' => [NonCommunicableDiseaseResource::make(!empty($this->ncdRiskAssessmentLatest) ? $this->ncdRiskAssessmentLatest : [[]])->resolve()],
        ];
    }
}
