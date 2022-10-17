<?php

namespace App\Models\V1\Patient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientVaccine extends Model
{
    protected $dates = ['vaccine_date'];
    protected $guarded = [
        'id',
    ];
}
