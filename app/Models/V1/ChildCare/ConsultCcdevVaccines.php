<?php

namespace App\Models\V1\Childcare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultCcdevVaccines extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $dates = ['vaccine_date'];
    protected $guarded = [
        'id',
    ];

}
