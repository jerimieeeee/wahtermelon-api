<?php

namespace App\Models\V1\AnimalBite;

use App\Models\V1\Libraries\LibAbDeathPlace;
use App\Models\V1\Libraries\LibAbOutcome;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientAb extends Model
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

    public function abExposure()
    {
        return $this->hasOne(PatientAbExposure::class, 'patient_ab_id', 'id');
    }

    public function abPostExposure()
    {
        return $this->hasOne(PatientAbPostExposure::class, 'patient_ab_id', 'id');
    }

    public function treatmentOutcome()
    {
        return $this->belongsTo(LibAbOutcome::class, 'ab_treatment_outcome_id', 'id');
    }

    public function deathPlace()
    {
        return $this->belongsTo(LibAbDeathPlace::class, 'ab_death_place_id', 'id');
    }
}
