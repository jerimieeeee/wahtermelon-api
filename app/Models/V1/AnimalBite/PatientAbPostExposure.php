<?php

namespace App\Models\V1\AnimalBite;

use App\Models\V1\Libraries\LibAbAnimalStatus;
use App\Models\V1\Libraries\LibAbRigType;
use App\Models\V1\Libraries\LibAbVaccine;
use App\Models\V1\Libraries\LibAbVaccineRoute;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAbPostExposure extends Model
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

    public function animalStatus()
    {
        return $this->belongsTo(LibAbAnimalStatus::class, 'animal_status_code', 'code');
    }

    public function rigType()
    {
        return $this->belongsTo(LibAbRigType::class, 'rig_type_code', 'code');
    }

    public function otherVaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'other_vacc_route_code', 'code');
    }

    // booster1Vaccine
    public function booster1Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'booster1_vaccine_code', 'code');
    }

    public function booster1VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'booster1_vaccine_route_code', 'code');
    }

    public function booster2Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'booster2_vaccine_code', 'code');
    }

    public function booster2VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'booster2_vaccine_route_code', 'code');
    }

    public function day0Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'day0_vaccine_code', 'code');
    }

    public function day0VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'day0_vaccine_route_code', 'code');
    }

    public function day3Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'day3_vaccine_code', 'code');
    }

    public function day3VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'day3_vaccine_route_code', 'code');
    }

    public function day7Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'day7_vaccine_code', 'code');
    }

    public function day7VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'day7_vaccine_route_code', 'code');
    }

    public function day14Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'day14_vaccine_code', 'code');
    }

    public function day14VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'day14_vaccine_route_code', 'code');
    }

    public function day28Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'day28_vaccine_code', 'code');
    }

    public function day28VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'day28_vaccine_route_code', 'code');
    }
}
