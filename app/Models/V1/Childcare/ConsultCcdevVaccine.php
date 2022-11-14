<?php

namespace App\Models\V1\Childcare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultCcdevVaccine extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'vaccine_date' => 'date:Y-m-d',
    ];

}
