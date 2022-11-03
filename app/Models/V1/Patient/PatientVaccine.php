<?php

namespace App\Models\V1\Patient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientVaccine extends Model
{
    use SoftDeletes ,HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'vaccine_date' => 'date:Y-m-d',
    ];
}
