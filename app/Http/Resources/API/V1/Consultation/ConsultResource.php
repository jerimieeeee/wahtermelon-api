<?php

namespace App\Http\Resources\API\V1\Consultation;

use App\Http\Resources\API\V1\Patient\PatientVitalsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultResource extends JsonResource
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
            'id' => $this->id,
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'transaction_number' => $this->transaction_number,
            'transmittal_number' => $this->transmittal_number,
            'consult_date' => $this->consult_date->format('Y-m-d H:i:s'),
            'is_konsulta' => $this->is_konsulta,
            'physician_id' => $this->when(! $this->relationLoaded('physician'), $this->physician_id),
            'physician' => $this->whenLoaded('physician'),
            'vitals' => $this->when($this->relationLoaded('vitals'), PatientVitalsResource::collection($this->vitals)),
            'consult_notes' => $this->whenLoaded('consultNotes'),
            'complaints' => $this->whenLoaded('consultNotes.complaints.libcomplaints'),
            'prescriptions' => $this->whenLoaded('prescription'),
            'management' => $this->whenLoaded('management'),
            'dentalMedicalSocials' => $this->whenLoaded('dentalMedicalSocials'),
            'dentalSurgicalHistory' => $this->whenLoaded('dentalSurgicalHistory'),
            'dentalHospitalizationHistory' => $this->whenLoaded('dentalHospitalizationHistory'),
            'dentalService' => $this->whenLoaded('dentalService'),
            'dentalToothService' => $this->whenLoaded('dentalToothService'),
            'consultToothCondition' => $this->whenLoaded('consultToothCondition'),
            'latestToothCondition' => $this->whenLoaded('latestToothCondition'),
            'dentalOralHealthCondition' => $this->whenLoaded('dentalOralHealthCondition'),
            'is_pregnant' => $this->is_pregnant,
            'consult_done' => $this->consult_done,
            'pt_group' => $this->pt_group,
            'authorization_transaction_code' => $this->authorization_transaction_code,
            'walkedin_status' => $this->walkedin_status,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
