<?php

namespace App\Models\V1\Mortality;

use App\Models\User;
use App\Models\V1\Libraries\LibIcd10;
use App\Models\V1\Libraries\LibMortalityCause;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class PatientDeathRecordCauses extends Model
{
    use HasFactory, FilterByUser, FilterByFacility, HasUlids;

    protected $guarded = [
        'id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function icd10()
    {
        return $this->belongsTo(LibIcd10::class, 'icd10', 'icd10_code');
    }

    public function cause()
    {
        return $this->belongsTo(LibMortalityCause::class, 'cause', 'code');
    }
}
