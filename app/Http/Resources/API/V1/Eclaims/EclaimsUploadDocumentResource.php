<?php

namespace App\Http\Resources\API\V1\Eclaims;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EclaimsUploadDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pHospitalTransmittalNo' => $this->pHospitalTransmittalNo,
            'doc_type_code' => $this->doc_type_code,
            'doc_url' => $this->doc_url,
            'created_at' => $this->created_at
        ];
    }
}
