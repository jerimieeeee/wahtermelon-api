<?php

namespace App\Http\Resources\API\V1\Konsulta;

use App\Models\V1\Consultation\Consult;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
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
            ->join('consult_notes', fn ($join) => $join->on('consults.id', '=', 'consult_notes.consult_id')->select('notes_id', 'consult_id'))
            ->join('consult_notes_pes', fn ($join) => $join->on('consult_notes.id', '=', 'consult_notes_pes.notes_id')->select('notes_id', 'pe_id'))
            ->join('lib_pes', fn ($join) => $join->on('lib_pes.pe_id', '=', 'consult_notes_pes.pe_id')->select('pe_id', 'category_id', 'konsulta_pe_id'))
            ->whereRaw('!ISNULL(konsulta_pe_id) AND consults.id = ? AND DATE_FORMAT(consult_date, "%Y-%m-%d") = ?', [$this->id ?? '', ! empty($this->consult_date) ? $this->consult_date->format('Y-m-d') : ''])
            ->groupByRaw('consult_notes.id, consult_notes_pes.pe_id')
            ->get();
        $physicalExamSpecific = Consult::query()
            ->join('consult_notes', fn ($join) => $join->on('consults.id', '=', 'consult_notes.consult_id')->select('notes_id', 'consult_id'))
            ->join('consult_pe_remarks', fn ($join) => $join->on('consult_notes.id', '=', 'consult_pe_remarks.notes_id'))
            ->whereRaw('consults.id = ? AND DATE_FORMAT(consult_date, "%Y-%m-%d") = ?', [$this->id ?? '', ! empty($this->consult_date) ? $this->consult_date->format('Y-m-d') : ''])
            ->first();

        $subjective = Consult::query()
            ->selectRaw("
                consults.id AS id,
                GROUP_CONCAT(DISTINCT history) AS history,
                GROUP_CONCAT(DISTINCT complaint) AS complaint,
                GROUP_CONCAT(CASE
                    WHEN konsulta_complaint_id = '38'
                    THEN complaint_desc
                END) AS complaint_desc,
                GROUP_CONCAT(konsulta_complaint_id SEPARATOR ';') AS konsulta_complaint_id
            ")
            ->join('consult_notes', fn ($join) => $join->on('consults.id', '=', 'consult_notes.consult_id')->select('notes_id', 'consult_id', 'history'))
            ->join('consult_notes_complaints', fn ($join) => $join->on('consult_notes.id', '=', 'consult_notes_complaints.notes_id')->select('notes_id', 'complaint_id'))
            ->join('lib_complaints', fn ($join) => $join->on('lib_complaints.complaint_id', '=', 'consult_notes_complaints.complaint_id')->select('complaint_id', 'complaint_desc', 'konsulta_complaint_id')->whereNotNull('konsulta_complaint_id'))
            ->whereRaw('consults.id = ?', $this->id ?? '')
            ->groupByRaw('consults.id')
            ->first();

        return [
            '_attributes' => [
                'pHciCaseNo' => $this->patient->case_number ?? '',
                'pHciTransNo' => ! empty($this->transaction_number) ? 'S'.$this->transaction_number : '',
                'pSoapDate' => ! empty($this->consult_date) ? $this->consult_date->format('Y-m-d') : '',
                'pPatientPin' => $this->philhealthLatest->philhealth_id ?? '',
                'pPatientType' => $this->philhealthLatest->membership_type_id ?? '',
                'pMemPin' => ! empty($this->philhealthLatest->member_pin) ? $this->philhealthLatest->member_pin : $this->philhealthLatest->philhealth_id ?? '',
                'pEffYear' => $this->philhealthLatest->effectivity_year ?? '',
                'pATC' => $this->authorization_transaction_code ?? '',
                'pIsWalkedIn' => ! empty($this->id) ? $this->authorization_transaction_code == 'WALKEDIN' ? 'Y' : 'N' : '',
                'pCoPay' => '',
                'pTransDate' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],

            'SUBJECTIVE' => [SubjectiveResource::make(! empty($subjective) ? $subjective : [[]])->resolve()],
            'PEPERT' => [PhysicalExaminationVitalsResource::make(! empty($this->vitalsLatest) ? $this->vitalsLatest : [[]])->resolve()],
            'PEMISCS' => [
                'PEMISC' => [PhysicalExaminationMiscResource::collection(! empty($physicalExam) ? $physicalExam->whenEmpty(fn () => [[]]) : [[]])->resolve()],
            ],
            'PESPECIFIC' => [PhysicalExaminationSpecificResource::make(! empty($physicalExamSpecific) ? $physicalExamSpecific : [[]])->resolve()],
            'ICDS' => [
                'ICD' => [DiagnosisResource::collection(! empty($this->finalDiagnosis) ? $this->finalDiagnosis : [[]])->resolve()],
            ],
            'DIAGNOSTICS' => [
                'DIAGNOSTIC' => [DiagnosticResource::collection(! empty($this->consultLaboratory) && count($this->consultLaboratory) > 0 ? $this->consultLaboratory : [[]])->resolve()],
            ],
            'MANAGEMENTS' => [
                'MANAGEMENT' => [ManagementResource::collection(! empty($this->management) ? $this->management : [[]])->resolve()],
            ],
            'ADVICE' => [AdviceResource::make(! empty($this->consultNotes) ? $this->consultNotes : [[]])->resolve()],
        ];
    }
}
