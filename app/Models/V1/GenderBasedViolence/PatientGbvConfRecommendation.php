<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\Libraries\LibGbvConferenceRecommendation;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbvConfRecommendation extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function getRouteKeyName()
    {
        return 'id';
    }

    protected $casts = [
        'recommendation_date' => 'date:Y-m-d',
    ];

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

    public function patientGbvConf()
    {
        return $this->belongsTo(PatientGbvConf::class, 'patient_gbv_conference_id', 'id');
    }

    public function recommendation()
    {
        return $this->belongsTo(LibGbvConferenceRecommendation::class, 'recommend_code', 'id');
    }
}
