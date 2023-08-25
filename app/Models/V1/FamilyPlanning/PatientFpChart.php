<?php

namespace App\Models\V1\FamilyPlanning;

use App\Models\User;
use App\Models\V1\Libraries\LibFpSourceSupply;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientFpChart extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids, FilterByFacility, CascadeSoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'service_date' => 'date:Y-m-d',
        'next_service_date' => 'date:Y-m-d',
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

    public function fpMethod()
    {
        return $this->belongsTo(PatientFpMethod::class, 'patient_fp_method_id', 'id');
    }

    public function source()
    {
        return $this->belongsTo(LibFpSourceSupply::class, 'source_supply_code', 'code');
    }
}
