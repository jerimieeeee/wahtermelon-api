<?php

namespace App\Models\V1\AnimalBite;

use App\Models\V1\Libraries\LibAbAnimalOwnership;
use App\Models\V1\Libraries\LibAbAnimalType;
use App\Models\V1\Libraries\LibAbExposureType;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAbExposure extends Model
{
    use HasFactory, HasUlids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    protected $keyType = 'string';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function animalType()
    {
        return $this->belongsTo(LibAbAnimalType::class, 'animal_type_id', 'id');
    }

    public function animalOwnership()
    {
        return $this->belongsTo(LibAbAnimalOwnership::class, 'animal_ownership_id', 'id');
    }

    public function exposureType()
    {
        return $this->belongsTo(LibAbExposureType::class, 'exposure_type_code', 'code');
    }
}
