<?php

namespace App\Models\V1\FamilyPlanning;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientFp extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids, FilterByFacility;

    protected $table = 'patient_fp';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [
        'id',
    ];

    public function getRouteKeyName()
    {
        return 'patient_id';
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

    public function fpHistory()
    {
        return $this->hasMany(PatientFpHistory::class);
    }

    public function fpPhysicalExam()
    {
        return $this->hasMany(PatientFpPhysicalExam::class);
    }

    public function fpPelvicExam()
    {
        return $this->hasMany(PatientFpPelvicExam::class);
    }

    public function fpMethod()
    {
        return $this->hasOne(PatientFpMethod::class)
            ->where('dropout_flag', '=', '0')
            ->orderBy('enrollment_date', 'DESC');
    }

    public function fpChart()
    {
        return $this->hasMany(PatientFpChart::class)
            ->orderBy('service_date', 'DESC');
    }
}
