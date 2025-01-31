<?php

namespace App\Http\Resources\API\V1\Konsulta;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\PatientVaccine;
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
        $vitals = PatientVitals::query()
            ->wherePatientId($this->id ?? '')->whereRaw("DATE_FORMAT(vitals_date, '%Y-%m-%d') = ?", $this->philhealthLatest->enlistment_date ?? '')
            ->whereNotNull('bp_systolic')
            ->whereNotNull('bp_diastolic')
            ->whereNotNull('patient_heart_rate')
            ->whereNotNull('patient_respiratory_rate')
            ->whereNotNull('patient_temp')
            ->whereNotNull('patient_height')
            ->whereNotNull('patient_weight')
            //->whereNotNull('patient_bmi')
            ->first();
        $physicalExam = Consult::query()
            ->selectRaw("
                consults.patient_id, consult_notes.id, consult_date,
                SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN category_id = 'SKIN'
                    THEN konsulta_pe_id
                END), ',', 1) as skin,
                SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN category_id = 'HEENT'
                    THEN konsulta_pe_id
                END), ',', 1) as heent,
                SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN category_id = 'CHEST'
                    THEN konsulta_pe_id
                END), ',', 1) as chest,
                SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN category_id = 'HEART'
                    THEN konsulta_pe_id
                END), ',', 1) as heart,
                SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN category_id = 'ABDOMEN'
                    THEN konsulta_pe_id
                END), ',', 1) as abdomen,
                SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN category_id = 'NEURO'
                    THEN konsulta_pe_id
                END), ',', 1) as neuro,
                SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN category_id = 'RECTAL'
                    THEN konsulta_pe_id
                END), ',', 1) as rectal,
                SUBSTRING_INDEX(GROUP_CONCAT(CASE
                    WHEN category_id = 'GENITOURINARY'
                    THEN konsulta_pe_id
                END), ',', 1) as genitourinary
            ")
            ->join('consult_notes', fn ($join) => $join->on('consults.id', '=', 'consult_notes.consult_id')->select('notes_id', 'consult_id'))
            ->join('consult_notes_pes', fn ($join) => $join->on('consult_notes.id', '=', 'consult_notes_pes.notes_id')->select('notes_id', 'pe_id'))
            ->join('lib_pes', fn ($join) => $join->on('lib_pes.pe_id', '=', 'consult_notes_pes.pe_id')->select('pe_id', 'category_id', 'konsulta_pe_id')->where('konsulta_library_status', 1))
            ->whereRaw('!ISNULL(konsulta_pe_id) AND consults.patient_id = ? AND DATE_FORMAT(consult_date, "%Y-%m-%d") = ?', [$this->id ?? '', $this->philhealthLatest->enlistment_date ?? ''])
            ->groupByRaw('consult_notes.id, consult_notes_pes.pe_id')
            ->get();
        $physicalExamSpecific = Consult::query()
            ->join('consult_notes', fn ($join) => $join->on('consults.id', '=', 'consult_notes.consult_id')->select('notes_id', 'consult_id'))
            ->join('consult_pe_remarks', fn ($join) => $join->on('consult_notes.id', '=', 'consult_pe_remarks.notes_id'))
            ->whereRaw('consults.patient_id = ? AND DATE_FORMAT(consult_date, "%Y-%m-%d") = ?', [$this->id ?? '', $this->philhealthLatest->enlistment_date ?? ''])
            ->first();
        $genSurvey = Consult::query()
            ->join('consult_notes', fn ($join) => $join->on('consults.id', '=', 'consult_notes.consult_id')->select('notes_id', 'consult_id'))
            ->whereRaw('consults.patient_id = ? AND DATE_FORMAT(consult_date, "%Y-%m-%d") = ?', [$this->id ?? '', $this->philhealthLatest->enlistment_date ?? ''])
            ->first();

        $immunizationChild = PatientVaccine::select('patient_id', 'vaccine_id')
            ->selectRaw('
                ROW_NUMBER() OVER (PARTITION BY patient_id, vaccine_id ORDER BY vaccine_id) as group_increment,
                CASE
                    WHEN vaccine_id = "BCG"
                    THEN "C01"
                    WHEN vaccine_id = "OPV"
                    THEN CONCAT("C0",ROW_NUMBER() OVER (PARTITION BY patient_id, vaccine_id ORDER BY vaccine_id) + 1)
                    WHEN vaccine_id = "DPT"
                    THEN CONCAT("C0",ROW_NUMBER() OVER (PARTITION BY patient_id, vaccine_id ORDER BY vaccine_id) + 4)
                    WHEN vaccine_id = "MCV"
                    THEN "C08"
                    WHEN vaccine_id = "HEPB"
                    THEN CONCAT("C", LPAD(8 + ROW_NUMBER() OVER (PARTITION BY patient_id, vaccine_id ORDER BY vaccine_id), 2, "0"))
                    WHEN vaccine_id = "HEPA"
                    THEN "C12"
                    WHEN vaccine_id = "CPV"
                    THEN "C13"
                END AS child_vaccine
            ')
            ->whereIn('vaccine_id', ['BCG', 'OPV', 'DPT', 'MCV', 'HEPB', 'CPV'])
            // ->whereIn('vaccine_id', ['x'])
            ->wherePatientId($this->id ?? '')
            ->get();

        $immunizationYoungWomen = PatientVaccine::query()
            ->selectRaw('
                CASE
                    WHEN vaccine_id = "HPV"
                    THEN "Y01"
                    WHEN vaccine_id IN ("MRGR", "MRGR7")
                    THEN "Y02"
                END AS young_women_vaccine
            ')
            ->whereHas('patient', fn ($query) => $query->where('gender', 'F'))
            ->whereIn('vaccine_id', ['HPV', 'MRGR', 'MRGR7'])
            // ->whereIn('vaccine_id', ['x'])
            ->wherePatientId($this->id ?? '')
            ->groupBy('vaccine_id')
            ->get();

        $immunizationPregnant = PatientVaccine::query()
            ->selectRaw('
                CASE
                    WHEN vaccine_id = "TD"
                    THEN "P01"
                END AS pregnant_women_vaccine
            ')
            ->whereHas('patient', fn ($query) => $query->where('gender', 'F'))
            ->where('vaccine_id', 'TD')
            // ->whereIn('vaccine_id', ['x'])
            ->wherePatientId($this->id ?? '')
            ->groupBy('vaccine_id')
            ->get();

        $immunizationElderly = PatientVaccine::query()
            ->selectRaw('
                CASE
                    WHEN vaccine_id = "PPV"
                    THEN "E01"
                    WHEN vaccine_id = "FLU"
                    THEN "E02"
                END AS elderly_vaccine
            ')
            ->whereIn('vaccine_id', ['PPV', 'FLU'])
            // ->whereIn('vaccine_id', ['x'])
            ->wherePatientId($this->id ?? '')
            ->groupBy('vaccine_id')
            ->get();

        $immunizationOther = PatientVaccine::query()
            ->select('vaccine_id')
            ->with('vaccines')
            ->whereNotIn('vaccine_id', ['BCG', 'OPV', 'DPT', 'MCV', 'HEPB', 'CPV', 'HPV', 'MRGR', 'MRGR7', 'TD', 'PPV', 'FLU'])
            // ->whereIn('vaccine_id', ['x'])
            ->wherePatientId($this->id ?? '')
            ->groupBy('vaccine_id')
            ->get();

        $profile = [
            '_attributes' => [
                'pHciTransNo' => ! empty($this->philhealthLatest->transaction_number) ? 'P'.$this->philhealthLatest->transaction_number : '',
                'pHciCaseNo' => $this->case_number ?? '',
                'pProfDate' => $this->philhealthLatest->enlistment_date ?? '',
                'pPatientPin' => $this->philhealthLatest->philhealth_id ?? '',
                'pPatientType' => $this->philhealthLatest->membership_type_id ?? '',
                'pPatientAge' => ! empty($this->birthdate) ? Carbon::parse($this->birthdate)->diff($this->philhealthLatest->enlistment_date ?? '')->y.' YR(S), '.Carbon::parse($this->birthdate)->diff($this->philhealthLatest->enlistment_date ?? '')->m.' MO(S), '.Carbon::parse($this->birthdate)->diff($this->philhealthLatest->enlistment_date ?? '')->d.' DAY(S)' : '',
                'pMemPin' => ! empty($this->philhealthLatest->member_pin) ? $this->philhealthLatest->member_pin : $this->philhealthLatest->philhealth_id ?? '',
                'pEffYear' => $this->philhealthLatest->effectivity_year ?? '',
                'pATC' => $this->philhealthLatest->authorization_transaction_code ?? 'WALKEDIN',
                'pIsWalkedIn' => ! empty($this->philhealthLatest) ? $this->philhealthLatest->authorization_transaction_code == 'WALKEDIN' ? 'Y' : 'N' : '',
                'pTransDate' => isset($this->philhealthLatest->created_at) ? $this->philhealthLatest->created_at->format('Y-m-d') : '',
                'pReportStatus' => 'U',
                'pDeficiencyRemarks' => '',
            ],
            'MEDHISTS' => [
                'MEDHIST' => [MedicalHistoryResource::collection(! empty($this->patientHistory) ? $this->patientHistory->whenEmpty(fn () => [[]]) : [[]])->resolve()],
            ],
            'MHSPECIFICS' => [
                'MHSPECIFIC' => [MedicalHistorySpecificResource::collection(! empty($this->patientHistorySpecifics) ? $this->patientHistorySpecifics->whenEmpty(fn () => [[]]) : [[]])->resolve()],
            ],
            'SURGHISTS' => [
                'SURGHIST' => [SurgicalHistoryResource::collection(! empty($this->surgicalHistory) ? $this->surgicalHistory->whenEmpty(fn () => [[]]) : [[]])->resolve()],
            ],
            'FAMHISTS' => [
                'FAMHIST' => [MedicalHistoryResource::collection(! empty($this->familyHistory) ? $this->familyHistory->whenEmpty(fn () => [[]]) : [[]])->resolve()],
            ],
            'FHSPECIFICS' => [
                'FHSPECIFIC' => [MedicalHistorySpecificResource::collection(! empty($this->familyHistorySpecifics) ? $this->familyHistorySpecifics->whenEmpty(fn () => [[]]) : [[]])->resolve()],
            ],
            'SOCHIST' => [SocialHistoryResource::make(! empty($this->socialHistory) ? $this->socialHistory : [[]])->resolve()],
            'IMMUNIZATIONS' => [
                'IMMUNIZATION' => [],
            ],
            'MENSHIST' => [MenstrualHistoryResource::make(! empty($this->menstrualHistory) ? $this->menstrualHistory : [[]])->resolve()],
            'PREGHIST' => [PregnancyHistoryResource::make(! empty($this->pregnancyHistory) ? $this->pregnancyHistory : [[]])->resolve()],
            'PEPERT' => [PhysicalExaminationVitalsResource::make(! empty($vitals) ? $vitals : [[]])->resolve()],
            'BLOODTYPE' => [
                '_attributes' => [

                    'pBloodType' => isset($this->blood_type_code) && $this->blood_type_code != 'NA' ? $this->blood_type_code : '',
                    'pReportStatus' => 'U',
                    'pDeficiencyRemarks' => '',
                ],
            ],
            'PEGENSURVEY' => [PhysicalExaminationGeneralSurveyResource::make(! empty($genSurvey) ? $genSurvey : [[]])->resolve()],
            'PEMISCS' => [
                'PEMISC' => [PhysicalExaminationMiscResource::collection(! empty($physicalExam) ? $physicalExam->whenEmpty(fn () => [[]]) : [[]])->resolve()],
            ],
            'PESPECIFIC' => [PhysicalExaminationSpecificResource::make(! empty($physicalExamSpecific) ? $physicalExamSpecific : [[]])->resolve()],
            'NCDQANS' => [NonCommunicableDiseaseResource::make(! empty($this->ncdRiskAssessmentLatest) ? $this->ncdRiskAssessmentLatest : [[]])->resolve()],
        ];

        array_push($profile['IMMUNIZATIONS']['IMMUNIZATION'], [ImmunizationResource::collection(! empty($immunizationChild) ? $immunizationChild->whenEmpty(fn () => [[]]) : [[]])->resolve()]);
        array_push($profile['IMMUNIZATIONS']['IMMUNIZATION'], [ImmunizationYoungWomenResource::collection(! empty($immunizationYoungWomen) ? $immunizationYoungWomen->whenEmpty(fn () => [[]]) : [[]])->resolve()]);
        array_push($profile['IMMUNIZATIONS']['IMMUNIZATION'], [ImmunizationPregnantWomenResource::collection(! empty($immunizationPregnant) ? $immunizationPregnant->whenEmpty(fn () => [[]]) : [[]])->resolve()]);
        array_push($profile['IMMUNIZATIONS']['IMMUNIZATION'], [ImmunizationElderlyResource::collection(! empty($immunizationElderly) ? $immunizationElderly->whenEmpty(fn () => [[]]) : [[]])->resolve()]);
        if (count($immunizationOther) > 0) {
            array_push($profile['IMMUNIZATIONS']['IMMUNIZATION'], [ImmunizationOtherResource::collection(count($immunizationOther) > 0 ? $immunizationOther : [[]])->resolve()]);
        }

        return $profile;
    }
}
