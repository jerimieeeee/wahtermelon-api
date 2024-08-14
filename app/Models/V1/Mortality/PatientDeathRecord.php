<?php

namespace App\Models\V1\Mortality;

use App\Models\User;
use App\Models\V1\Libraries\LibIcd10;
use App\Models\V1\Libraries\LibMortalityDeathPlace;
use App\Models\V1\Libraries\LibMortalityDeathType;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class PatientDeathRecord extends Model
{
    use HasFactory, FilterByUser, FilterByFacility, HasUlids;

    protected $guarded = [
        'id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $casts = [
        'date_of_death' => 'date:Y-m-d H:i:s',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }


    public function deathType()
    {
        return $this->belongsTo(LibMortalityDeathType::class, 'death_type', 'code');
    }

    public function deathPlace()
    {
        return $this->belongsTo(LibMortalityDeathPlace::class, 'death_place', 'code');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'psgc_10_digit_code');
    }

    public function immediateCause()
    {
        return $this->belongsTo(LibIcd10::class, 'immediate_cause', 'icd10_code')
            ->selectRaw('
                icd10_code,
                icd10_desc
            ');
    }

    public function deathCause()
    {
        return $this->hasMany(PatientDeathRecordCauses::class, 'death_record_id', 'id')
        ->selectRaw('
                death_record_id,
                icd10_code,
                cause_code
            ');
    }
}
