<?php

namespace App\Models\V1\Patient;

use App\Models\V1\Libraries\LibFpMethod;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMenstrualHistory extends Model
{
    use HasFactory, HasUuids, FilterByUser;

    protected $table = 'patient_menstrual_histories';

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

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function libFpMethod()
    {
        return $this->belongsTo(LibFpMethod::class, 'method', 'id');
    }
}
