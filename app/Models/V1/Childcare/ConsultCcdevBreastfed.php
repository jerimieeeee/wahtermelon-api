<?php

namespace App\Models\V1\Childcare;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultCcdevBreastfed extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = ['id',];

    // protected $dates = ['deleted_at'];

    protected $casts = [
        'ebf_date' => 'date:Y-m-d',
    ];

    public function getRouteKeyName()
    {
        return 'patient_id';
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function patientccdev(){

        return $this->belongsTo(PatientCcdev::class);
    }
}
