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
        return [
            'id' => $this->id,
            'facility_code' => $this->when(!$this->relationLoaded('facility'),$this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'user_id' => $this->when(!$this->relationLoaded('user'),$this->user_id),
            'user' => $this->whenLoaded('user'),
            'transmittal_number' => $this->transmittal_number,
            'patient' => $this->whenLoaded('patient'),
            'tranche' => $this->tranche,
            'total_enlistment' => $this->total_enlistment,
            'total_profile' => $this->total_profile,
            'total_soap' => $this->total_soap,
            'xml_url' => $this->xml_url,
            'file_name' => str_replace("Konsulta/".auth()->user()->facility_code."/","",$this->xml_url),
            'konsulta_transaction_number' => $this->konsulta_transaction_number,
            'xml_status' => $this->xml_status,
            'xml_errors' => $this->xml_errors,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
