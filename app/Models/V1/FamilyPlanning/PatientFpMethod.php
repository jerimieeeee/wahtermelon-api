<?php

namespace App\Models\V1\FamilyPlanning;

use App\Models\User;
use App\Models\V1\Libraries\LibFpClientType;
use App\Models\V1\Libraries\LibFpDropoutReason;
use App\Models\V1\Libraries\LibFpMethod;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientFpMethod extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids, FilterByFacility, CascadeSoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'enrollment_date' => 'date:Y-m-d',
    ];

    protected $cascadeDeletes = [
        'chart',
    ];

    protected $attributes = [
        'dropout_flag' => 0,
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

    public function method()
    {
        return $this->belongsTo(LibFpMethod::class, 'method_code', 'code');
    }

    public function client()
    {
        return $this->belongsTo(LibFpClientType::class, 'client_code', 'code');
    }

    public function dropout()
    {
        return $this->belongsTo(LibFpDropoutReason::class, 'dropout_reason_code', 'code');
    }

    public function chart()
    {
        return $this->hasOne(PatientFpChart::class, 'patient_fp_method_id', 'id');
    }
}
