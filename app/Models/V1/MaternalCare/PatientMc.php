<?php

namespace App\Models\V1\MaternalCare;

use App\Models\V1\PSGC\Facility;
use App\Traits\HasUuid;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientMc extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, HasUuid;

    protected $table = 'patient_mc';

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'pre_registration_date' => 'date:Y-m-d',
        'post_registration_date' => 'date:Y-m-d',
        'lmp_date' => 'date:Y-m-d',
        'edc_date' => 'date:Y-m-d',
        'trimester1_date' => 'date:Y-m-d',
        'trimester2_date' => 'date:Y-m-d',
        'trimester3_date' => 'date:Y-m-d',
        'postpartum_date' => 'date:Y-m-d',
        'admission_date' => 'datetime:Y-m-d H:i:s',
        'discharge_date' => 'datetime:Y-m-d H:i:s',
        'delivery_date' => 'datetime:Y-m-d H:i:s',
        'healthy_baby' => 'boolean',
        'breastfeeding' => 'boolean',
        'end_pregnancy' => 'boolean',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function facility()
    {
        $this->belongsTo(Facility::class, 'facility_code', 'code');
    }
}
