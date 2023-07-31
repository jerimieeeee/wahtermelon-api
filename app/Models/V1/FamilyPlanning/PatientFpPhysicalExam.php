<?php

namespace App\Models\V1\FamilyPlanning;

use App\Models\User;
use App\Models\V1\Libraries\LibFpHistory;
use App\Models\V1\Libraries\LibPe;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientFpPhysicalExam extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids, FilterByFacility;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

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

    public function physicalExam()
    {
        return $this->belongsTo(LibPe::class, 'pe_id', 'pe_id');
    }
}
