<?php

namespace App\Models\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientMcPreRegistration extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'pre_registration_date' => 'date:Y-m-d',
        'lmp_date' => 'date:Y-m-d',
        'edc_date' => 'date:Y-m-d',
        'trimester1_date' => 'date:Y-m-d',
        'trimester2_date' => 'date:Y-m-d',
        'trimester3_date' => 'date:Y-m-d',
        'postpartum_date' => 'date:Y-m-d',
        'initial_gravidity' => 'integer',
        'initial_parity' => 'integer',
        'initial_full_term' => 'integer',
        'initial_preterm' => 'integer',
        'initial_abortion' => 'integer',
        'initial_livebirths' => 'integer',
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

    public function patientMc()
    {
        return $this->belongsTo(PatientMc::class);
    }
}
