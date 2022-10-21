<?php

namespace App\Models\V1\Patient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientVaccine extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'vaccine_date' => 'date:Y-m-d',
    ];
}
