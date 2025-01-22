<?php

namespace App\Models\V1\Eclaims;

use App\Models\User;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use App\Models\V1\AnimalBite\PatientAb;
use App\Models\V1\Childcare\PatientCcdev;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\TBDots\PatientTb;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EclaimsCaserateList extends Model
{
    use HasFactory, HasUlids, FilterByUser, FilterByFacility;

    protected $guarded = [
        'id',
    ];

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

    public function attendant()
    {
        return $this->belongsTo(User::class, 'caserate_attendant', 'id');
    }

    public function patientTb()
    {
        return $this->hasOne(PatientTb::class, 'id','program_id');
    }

    public function patientCc()
    {
        return $this->hasOne(PatientCcdev::class, 'id','program_id');
    }

    public function patientAb()
    {
        return $this->hasOne(PatientAb::class, 'id','program_id');
    }

    public function patientMc()
    {
        return $this->hasOne(PatientMc::class, 'id','program_id');
    }
}
