<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class KonsultaTransmittalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $facilityCode = auth()->user()->facility_code ?? '';
        $patient = [];
        if ($this->tranche == 1) {
            $patient = $this->patientPhilhealth->load(['philhealth' => function ($query) {
                $query->select('id', 'patient_id', 'philhealth_id', 'transmittal_number', 'enlistment_date', 'effectivity_year'); // Specify the columns you want to select from the philhealth table
                $query->where('effectivity_year', $this->effectivity_year);
                $query->with(['konsultaRegistration' => function ($query) {
                    $query->where('effectivity_year', $this->effectivity_year)
                        ->select('id', 'philhealth_id', 'assigned_date');
                }]);
            }]);
        }
        if ($this->tranche == 2) {
            $patient = $this->patientConsult->load(['philhealth' => function ($query) {
                $query->select('id', 'patient_id', 'philhealth_id', 'transmittal_number', 'enlistment_date', 'effectivity_year'); // Specify the columns you want to select from the philhealth table
                $query->where('effectivity_year', $this->effectivity_year);
                $query->with(['konsultaRegistration' => function ($query) {
                    $query->where('effectivity_year', $this->effectivity_year)
                        ->select('id', 'philhealth_id', 'assigned_date');
                }]);
            }, 'consult' => function ($query) {
                $query->where('transmittal_number', $this->transmittal_number)
                    ->select('id', 'patient_id', 'transmittal_number', 'consult_date');
            }]);
        }
        return [
            'id' => $this->id,
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'transmittal_number' => $this->transmittal_number,
            'effectivity_year' => $this->effectivity_year,
            'case_number' => $this->case_number,
            'philhealth_id' => $this->philhealth_id,
            'registration_date' => $this->enlistment_date ? (is_string($this->enlistment_date) ? date('m-d-Y', strtotime($this->enlistment_date)) : $this->enlistment_date->format('m-d-Y')) : null,
            'fpe_date' => $this->enlistment_date ? (is_string($this->enlistment_date) ? date('m-d-Y', strtotime($this->enlistment_date)) : $this->enlistment_date->format('m-d-Y')) : null,
            'ekas_date' => $this->consult_date ? (is_string($this->consult_date) ? date('m-d-Y', strtotime($this->consult_date)) : $this->consult_date->format('m-d-Y')) : null,
            'with_laboratory' => $this->with_laboratory,
            'epress_date' => $this->epress_date ? (is_string($this->epress_date) ? date('m-d-Y', strtotime($this->epress_date)) : $this->epress_date->format('m-d-Y')) : null,
            'patient' => $patient,
            'tranche' => $this->tranche,
            'total_enlistment' => $this->total_enlistment,
            'total_profile' => $this->total_profile,
            'total_soap' => $this->total_soap,
            'xml_url' => $this->xml_url,
            'file_name' => str_replace('Konsulta/'.$facilityCode.'/', '', $this->xml_url),
            'konsulta_transaction_number' => $this->konsulta_transaction_number,
            'xml_status' => $this->xml_status,
            'xml_errors' => $this->xml_errors,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
