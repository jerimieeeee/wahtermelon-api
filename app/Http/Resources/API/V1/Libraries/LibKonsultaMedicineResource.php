<?php

namespace App\Http\Resources\API\V1\Libraries;

use Illuminate\Http\Resources\Json\JsonResource;

class LibKonsultaMedicineResource extends JsonResource
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
            'code' => $this->code,
            'desc' => $this->desc,
            'generic_code' => $this->when(!$this->relationLoaded('generic'), $this->generic_code),
            'generic_desc' => $this->generic->desc,
            //'generic' => $this->when($this->relationLoaded('generic'), new LibKonsultaMedicineGenericResource($this->generic)),
            'salt_code' => $this->when(!$this->relationLoaded('salt'), $this->salt_code),
            'salt_desc' => $this->salt->desc,
            //'salt' => $this->when($this->relationLoaded('salt'), new LibKonsultaMedicineSaltResource($this->salt)),
            'form_code' => $this->when(!$this->relationLoaded('form'), $this->form_code),
            'form_desc' => $this->form->desc,
            //'form' => $this->when($this->relationLoaded('form'), new LibKonsultaMedicineFormResource($this->form)),
            'strength_code' => $this->when(!$this->relationLoaded('strength'), $this->strength_code),
            'strength_desc' => $this->strength->desc,
            //'strength' => $this->when($this->relationLoaded('strength'), new LibKonsultaMedicineStrengthResource($this->strength)),
            'unit_code' => $this->when(!$this->relationLoaded('unit'), $this->unit_code),
            'unit_desc' => $this->unit->desc,
            //'unit' => $this->when($this->relationLoaded('unit'), new LibKonsultaMedicineUnitResource($this->unit)),
            'package_code' => $this->when(!$this->relationLoaded('package'), $this->package_code),
            'package_desc' => $this->package->desc,
            //'package' => $this->when($this->relationLoaded('package'), new LibKonsultaMedicinePackageResource($this->package)),
            'category' => $this->category,
        ];
    }
}
