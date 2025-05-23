<?php

namespace App\Models\V1\NCD;

use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientNcdRecord extends Model
{
    use HasFactory, HasUuids, FilterByUser;

    protected $table = 'patient_ncd_records';

    protected $guarded = [
        'id',
    ];

    public function getRouteKeyName()
    {
        return 'consult_ncd_risk_id';
    }

    public $incrementing = false;

    protected $keyType = 'string';

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

    public function patientNcd()
    {
        return $this->belongsTo(PatientNcd::class, 'patient_ncd_id', 'id');
    }

    public function consultRiskAssessment()
    {
        return $this->belongsTo(ConsultNcdRiskAssessment::class, 'consult_ncd_risk_id', 'id');
    }

    public function ncdRecordDiagnosis()
    {
        return $this->hasMany(PatientNcdRecordDiagnosis::class, 'patient_ncd_record_id', 'id');
    }

    public function ncdRecordTargetOrgan()
    {
        return $this->hasMany(PatientNcdRecordTargetOrgan::class, 'patient_ncd_record_id', 'id');
    }

    public function ncdRecordCounselling()
    {
        return $this->hasMany(PatientNcdRecordCounselling::class, 'patient_ncd_record_id', 'id');
    }
}
