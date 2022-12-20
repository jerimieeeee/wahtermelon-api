<?php

namespace App\Models\V1\NCD;

use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientNcdRecordTargetOrgan extends Model
{
    use HasFactory, HasUuid, FilterByUser;

    protected $table = 'patient_ncd_record_target_organs';

    protected $guarded = [
        'id'
    ];

    public function getRouteKeyName()
    {
        return 'patient_ncd_id';
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

    public function patientNcdRecord()
    {
        return $this->belongsTo(PatientNcdRecord::class, 'patient_ncd_record_id', 'id');
    }

    public function consultRiskAssessment(): BelongsTo
    {
        return $this->belongsTo(ConsultNcdRiskAssessment::class, 'consult_ncd_risk_id', 'id');
    }
}
