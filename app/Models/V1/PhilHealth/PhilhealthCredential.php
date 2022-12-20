<?php

namespace App\Models\V1\PhilHealth;

use App\Models\User;
use App\Models\V1\Libraries\LibPhilhealthProgram;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhilhealthCredential extends Model
{
    use HasFactory, SoftDeletes, HasUuid, FilterByUser, FilterByFacility;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setFacilityNameAttribute($value)
    {
        $this->attributes["facility_name"] = strtoupper($value);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(LibPhilhealthProgram::class, 'program_code', 'code');
    }
}
