<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Models\V1\Libraries\LibGbvEconomicStatus;
use App\Models\V1\Libraries\LibGbvLivingArrangement;
use App\Models\V1\Libraries\LibGbvOutcomeReason;
use App\Models\V1\Libraries\LibGbvOutcomeResult;
use App\Models\V1\Libraries\LibGbvOutcomeVerdict;
use App\Models\V1\Libraries\LibGbvPrimaryComplaints;
use App\Models\V1\Libraries\LibGbvService;
use App\Models\V1\Libraries\LibGbvSleepingArrangement;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbv extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'case_date' => 'date:Y-m-d',
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

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(LibGbvPrimaryComplaints::class, 'primary_complaint_id', 'id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(LibGbvService::class, 'service_id', 'id');
    }

    public function economic(): BelongsTo
    {
        return $this->belongsTo(LibGbvEconomicStatus::class, 'economic_status_id', 'id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'code');
    }

    public function relation()
    {
        return $this->belongsTo(LibGbvChildRelation::class, 'relation_to_child_id', 'id');
    }

    public function sleepingArrangement()
    {
        return $this->belongsTo(LibGbvSleepingArrangement::class, 'sleeping_arrangement_id', 'id');
    }

    public function livingArrangement()
    {
        return $this->belongsTo(LibGbvLivingArrangement::class, 'abuse_living_arrangement_id', 'id');
    }

    public function presentArrangement()
    {
        return $this->belongsTo(LibGbvLivingArrangement::class, 'present_living_arrangement_id', 'id');
    }

    public function neglect()
    {
        return $this->hasOne(PatientGbvNeglect::class, 'patient_gbv_id', 'id');
    }

    public function complaints()
    {
        return $this->hasOne(PatientGbvComplaint::class, 'patient_gbv_id', 'id');
    }

    public function behavior()
    {
        return $this->hasOne(PatientGbvBehavior::class, 'patient_gbv_id', 'id');
    }

    public function referral()
    {
        return $this->hasOne(PatientGbvReferral::class, 'patient_gbv_id', 'id');
    }
}
