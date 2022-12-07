<?php

namespace App\Models\V1\Patient;

use App\Models\User;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientVitals extends Model
{
    use HasFactory, HasUuid, FilterByUser;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'vitals_date' => 'datetime:Y-m-d H:i:s',
        'bp_diastolic' => 'integer',
        'bp_systolic' => 'integer'
    ];

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
}
