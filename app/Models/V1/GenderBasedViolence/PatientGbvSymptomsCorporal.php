<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\V1\Libraries\LibGbvSymptomsCorporal;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbvSymptomsCorporal extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'incident_first_datetime' => 'date:Y-m-d H:i:s',
    ];

    public function getRouteKeyName()
    {
        return 'id';
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

    public function patientGbvIntake()
    {
        return $this->belongsTo(PatientGbvIntake::class, 'patient_gbv_intake_id', 'id');
    }

    public function corporal()
    {
        return $this->belongsTo(LibGbvSymptomsCorporal::class, 'corporal_symptoms_id', 'id');
    }
}
