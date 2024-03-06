<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Models\V1\Libraries\LibGbvPerpetratorLocation;
use App\Models\V1\Libraries\LibOccupation;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbvInterviewPerpetrator extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function patientGbv()
    {
        return $this->belongsTo(PatientGbvIntake::class, 'intake_id', 'id');
    }

    public function relation()
    {
        return $this->belongsTo(LibGbvChildRelation::class, 'child_relation_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(LibGbvPerpetratorLocation::class, 'location_id', 'id');
    }

    public function occupation()
    {
        return $this->belongsTo(LibOccupation::class, 'occupation_code', 'code');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'psgc_10_digit_code');
    }
}
