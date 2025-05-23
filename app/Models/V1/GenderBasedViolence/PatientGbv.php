<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\Libraries\LibGbvOutcomeReason;
use App\Models\V1\Libraries\LibGbvOutcomeResult;
use App\Models\V1\Libraries\LibGbvOutcomeVerdict;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbv extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids, FilterByFacility;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'gbv_date' => 'date:Y-m-d',
        'outcome_date' => 'date:Y-m-d',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected function serializeDate(\DateTimeInterface $date)
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

    public function outcomeReason(): BelongsTo
    {
        return $this->belongsTo(LibGbvOutcomeReason::class, 'outcome_reason_id', 'id');
    }

    public function outcomeResult(): BelongsTo
    {
        return $this->belongsTo(LibGbvOutcomeResult::class, 'outcome_result_id', 'id');
    }

    public function outcomeVerdict(): BelongsTo
    {
        return $this->belongsTo(LibGbvOutcomeVerdict::class, 'outcome_verdict_id', 'id');
    }

    public function gbvComplaint()
    {
        return $this->hasMany(PatientGbvComplaint::class, 'patient_gbv_id', 'id');
    }

    public function gbvBehavior()
    {
        return $this->hasMany(PatientGbvBehavior::class, 'patient_gbv_id', 'id');
    }

    public function gbvNeglect()
    {
        return $this->hasMany(PatientGbvNeglect::class, 'patient_gbv_id', 'id');
    }

    public function gbvReferral()
    {
        return $this->hasMany(PatientGbvReferral::class, 'patient_gbv_id', 'id');
    }

    public function gbvIntake()
    {
        return $this->hasOne(PatientGbvIntake::class, 'patient_gbv_id', 'id');
    }
}
