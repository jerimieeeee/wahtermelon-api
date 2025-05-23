<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\Libraries\LibGbvEmotionalAbuse;
use App\Models\V1\Libraries\LibGbvInfoSource;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbvEmotionalAbuse extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids;

    protected $table = 'patient_gbv_interview_emotional_abuses';

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

    public function emotionalAbuse()
    {
        return $this->belongsTo(LibGbvEmotionalAbuse::class, 'emotional_id', 'id');
    }

    public function infoSource()
    {
        return $this->belongsTo(LibGbvInfoSource::class, 'info_source_id', 'id');
    }
}
