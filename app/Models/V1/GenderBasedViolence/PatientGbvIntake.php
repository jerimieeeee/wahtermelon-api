<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbvIntake extends Model
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
        return $this->hasMany(PatientGbvNeglect::class, 'patient_gbv_intake_id', 'id');
    }

    public function complaints()
    {
        return $this->hasMany(PatientGbvComplaint::class, 'patient_gbv_intake_id', 'id');
    }

    public function behavior()
    {
        return $this->hasMany(PatientGbvBehavior::class, 'patient_gbv_intake_id', 'id');
    }

    public function interview()
    {
        return $this->hasOne(PatientGbvInterview::class, 'patient_gbv_intake_id', 'id');
    }

    public function interviewPerpetrator()
    {
        return $this->hasMany(PatientGbvInterviewPerpetrator::class, 'intake_id', 'id');
    }

    public function interviewSexualAbuses()
    {
        return $this->hasMany(PatientGbvInterviewSexualAbuse::class, 'intake_id', 'id');
    }

    public function interviewPhysicalAbuses()
    {
        return $this->hasMany(PatientGbvInterviewPhysicalAbuse::class, 'intake_id', 'id');
    }

    public function interviewNeglectAbuses()
    {
        return $this->hasMany(PatientGbvInterviewNeglectAbuse::class, 'intake_id', 'id');
    }

    public function interviewEmotionalAbuses()
    {
        return $this->hasMany(PatientGbvEmotionalAbuse::class, 'intake_id', 'id');
    }

    public function interviewSummaries()
    {
        return $this->hasMany(PatientGbvInterviewSummary::class, 'intake_id', 'id');
    }

    public function interviewDevScreening()
    {
        return $this->hasMany(PatientGbvInterviewDevScreening::class, 'intake_id', 'id');
    }

    public function interventionSocialWork()
    {
        return $this->hasMany(PatientGbvSocialWork::class, 'patient_gbv_intake_id', 'id');
    }

    public function interventionPlacement()
    {
        return $this->hasMany(PatientGbvPlacement::class, 'patient_gbv_intake_id', 'id');
    }

    public function interventionPsych()
    {
        return $this->hasMany(PatientGbvPsych::class, 'patient_gbv_intake_id', 'id');
    }

    public function interventionLegal()
    {
        return $this->hasOne(PatientGbvLegalCase::class, 'patient_gbv_intake_id', 'id');
    }

    public function caseConference()
    {
        return $this->hasMany(PatientGbvConf::class, 'patient_gbv_intake_id', 'id');
    }

    public function consult()
    {
        return $this->hasOne(PatientGbvConsult::class, 'patient_gbv_intake_id', 'id');
    }

    public function consultVisit()
    {
        return $this->hasMany(PatientGbvConsultVisit::class, 'patient_gbv_intake_id', 'id');
    }

    public function anogenital()
    {
        return $this->hasMany(PatientGbvSymptomsAnogenital::class, 'patient_gbv_intake_id', 'id');
    }
}
