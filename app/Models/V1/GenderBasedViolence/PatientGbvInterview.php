<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\User;
use App\Models\V1\Libraries\LibGbvAbusedEpisode;
use App\Models\V1\Libraries\LibGbvAbusedSite;
use App\Models\V1\Libraries\LibGbvChildBehavior;
use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Models\V1\Libraries\LibGbvDisclosedType;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbvInterview extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'incident_first_datetime' => 'date:Y-m-d H:i:s',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

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

    public function patientGbv()
    {
        return $this->belongsTo(PatientGbvIntake::class, 'patient_gbv_intake_id', 'id');
    }

    public function disclosed()
    {
        return $this->belongsTo(LibGbvDisclosedType::class, 'disclosed_type', 'id');
    }

    public function abusedEpisode()
    {
        return $this->belongsTo(LibGbvAbusedEpisode::class, 'abused_episode_id', 'id');
    }

    public function abusedSite()
    {
        return $this->belongsTo(LibGbvAbusedSite::class, 'abused_site_id', 'id');
    }

    public function relation()
    {
        return $this->belongsTo(LibGbvChildRelation::class, 'relation_to_child', 'id');
    }

    public function behavior()
    {
        return $this->belongsTo(LibGbvChildBehavior::class, 'child_behavior_id', 'id');
    }
}
