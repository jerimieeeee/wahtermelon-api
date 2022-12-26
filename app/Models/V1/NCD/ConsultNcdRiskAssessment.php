<?php

namespace App\Models\V1\NCD;

use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultNcdRiskAssessment extends Model
{
    use HasFactory, SoftDeletes, HasUuid, FilterByUser;

    protected $table = 'consult_ncd_risk_assessment';

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'assessment_date' => 'date:Y-m-d',
        'obesity' => 'boolean',
        'central_adiposity' => 'boolean',
        'raised_bp' => 'boolean',
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
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function patientNcd()
    {
        return $this->belongsTo(PatientNcd::class, 'patient_ncd_id', 'id');
    }

    public function riskScreeningGlucose()
    {
        return $this->hasOne(ConsultNcdRiskScreeningBloodGlucose::class, 'consult_ncd_risk_id', 'id');
    }

    public function riskScreeningLipid()
    {
        return $this->hasOne(ConsultNcdRiskScreeningBloodLipid::class, 'consult_ncd_risk_id', 'id');
    }

    public function riskScreeningKetones()
    {
        return $this->hasOne(ConsultNcdRiskScreeningUrineKetones::class, 'consult_ncd_risk_id', 'id');
    }

    public function riskScreeningProtein()
    {
        return $this->hasOne(ConsultNcdRiskScreeningUrineProtein::class, 'consult_ncd_risk_id', 'id');
    }

    public function riskQuestionnaire()
    {
        return $this->hasOne(ConsultNcdRiskQuestionnaire::class, 'consult_ncd_risk_id', 'id');
    }

    public function patientNcdRecord()
    {
        return $this->hasOne(PatientNcdRecord::class, 'consult_ncd_risk_id', 'id');
    }

    public function ncdRecordDiagnosis()
    {
        return $this->hasOne(PatientNcdRecordDiagnosis::class, 'consult_ncd_risk_id', 'id');
    }

    public function ncdRecordTargetOrgan()
    {
        return $this->hasOne(PatientNcdRecordTargetOrgan::class, 'consult_ncd_risk_id', 'id');
    }

    public function ncdRecordCounselling()
    {
        return $this->hasOne(PatientNcdRecordCounselling::class, 'consult_ncd_risk_id', 'id');
    }

}
