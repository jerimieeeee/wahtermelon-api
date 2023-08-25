<?php

namespace App\Models\V1\AnimalBite;

use App\Models\V1\Libraries\LibAbIndicationOption;
use App\Models\V1\Libraries\LibAbVaccine;
use App\Models\V1\Libraries\LibAbVaccineRoute;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAbPreExposure extends Model
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

    public function indicationOption()
    {
        return $this->belongsTo(LibAbIndicationOption::class, 'indication_option_code', 'code');
    }

    public function day0Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'day0_vaccine_code', 'code');
    }

    public function day0VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'day0_vaccine_route_code', 'code');
    }

    public function day7Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'day7_vaccine_code', 'code');
    }

    public function day7VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'day7_vaccine_route_code', 'code');
    }

    public function day21Vaccine()
    {
        return $this->belongsTo(LibAbVaccine::class, 'day21_vaccine_code', 'code');
    }

    public function day21VaccineRoute()
    {
        return $this->belongsTo(LibAbVaccineRoute::class, 'day21_vaccine_route_code', 'code');
    }
}
