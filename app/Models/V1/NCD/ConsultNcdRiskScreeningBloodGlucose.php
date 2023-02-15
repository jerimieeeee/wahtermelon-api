<?php

namespace App\Models\V1\NCD;

use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultNcdRiskScreeningBloodGlucose extends Model
{
    use HasFactory, HasUuids, FilterByUser;

    protected $table = 'consult_ncd_risk_screening_glucose';

    protected $guarded = [
        'id',
    ];

    public function getRouteKeyName()
    {
        return 'consult_ncd_risk_id';
    }

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'date_taken' => 'date:Y-m-d',
        'raised_blood_glucose' => 'boolean',
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

    public function patientNcd()
    {
        return $this->belongsTo(PatientNcd::class, 'patient_ncd_id', 'id');
    }

    public function consultRiskAssessment()
    {
        return $this->belongsTo(ConsultNcdRiskAssessment::class, 'consult_ncd_risk_id', 'id');
    }

}
