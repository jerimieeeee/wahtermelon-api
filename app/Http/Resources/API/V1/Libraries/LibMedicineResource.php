<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibMedicineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'hprodid' => $this->hprodid,
            'drug_name' => $this->drug_name,
            'gen_name' => $this->gen_name,
            'form_desc' => $this->form_desc,
            'stre_desc' => $this->stre_desc
        ];
    }
}
