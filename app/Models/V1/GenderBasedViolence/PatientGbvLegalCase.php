<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Models\V1\Libraries\LibGbvChildRelation;
use App\Models\V1\Libraries\LibGbvLegalFilingLocation;
use App\Models\V1\Libraries\LibGbvOutcomeVerdict;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbvLegalCase extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'cpumd_testimony_date' => 'date:Y-m-d',
    ];

    public function getRouteKeyName()
    {
        return 'id';
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

    public function relation()
    {
        return $this->belongsTo(LibGbvChildRelation::class, 'filed_by_relation_id', 'id');
    }

    public function filedLocation()
    {
        return $this->belongsTo(LibGbvLegalFilingLocation::class, 'filed_location_id', 'id');
    }

    public function verdict()
    {
        return $this->belongsTo(LibGbvOutcomeVerdict::class, 'verdict_id', 'id');
    }
}
