<?php

namespace App\Models\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcPregnancyTermination;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\HasUuid;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientMc extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, HasUuid;

    protected $table = 'patient_mc';

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'pregnancy_termination_date' => 'date:Y-m-d',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function preRegister()
    {
        return $this->hasOne(PatientMcPreRegistration::class);
    }

    public function postRegister()
    {
        return $this->hasOne(PatientMcPostRegistration::class);
    }

    public function prenatal()
    {
        return $this->hasMany(ConsultMcPrenatal::class)->orderBy('prenatal_date', 'DESC');
    }

    public function postpartum()
    {
        return $this->hasMany(ConsultMcPostpartum::class)->orderBy('postpartum_date', 'DESC');
    }

    public function pregnancyTermination()
    {
        return $this->belongsTo(LibMcPregnancyTermination::class);
    }

    public function riskFactor()
    {
        return $this->hasMany(ConsultMcRisk::class);
    }
}
