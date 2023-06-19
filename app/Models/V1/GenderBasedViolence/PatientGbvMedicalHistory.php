<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\V1\Libraries\LibGbvGeneralSurvey;
use App\Models\V1\Libraries\LibGbvInfoSource;
use App\Models\V1\Libraries\LibGbvMedicalImpression;
use App\Models\V1\Libraries\LibGbvSymptomsAnogenital;
use App\Models\V1\Libraries\LibGeneralSurvey;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbvMedicalHistory extends Model
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

    public function patientGbvIntake()
    {
        return $this->belongsTo(PatientGbvIntake::class, 'patient_gbv_intake_id', 'id');
    }

    public function medicalImpression()
    {
        return $this->belongsTo(LibGbvMedicalImpression::class, 'medical_impression_id', 'id');
    }
}
