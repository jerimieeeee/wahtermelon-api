<?php

namespace App\Models\V1\GenderBasedViolence;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientGbv extends Model
{
    use SoftDeletes ,HasFactory, FilterByUser;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'vaccine_date' => 'date:Y-m-d',
    ];
}
