<?php

namespace App\Models\V1\NCD;

use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientNcd extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, HasUuid, FilterByUser;

    protected $table = 'patient_ncd';

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'date_enrolled' => 'date:Y-m-d',
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

    public function riskAssessment()
    {
        return $this->hasMany(ConsultNcdRiskAssessment::class);
    }

    // public function riskScreeningGlucose()
    // {
    //     return $this->hasMany(ConsultNcdRiskScreeningBloodGlucose::class);
    // }

    // public function riskScreeningLipid()
    // {
    //     return $this->hasMany(ConsultNcdRiskScreeningBloodLipid::class);
    // }

}
