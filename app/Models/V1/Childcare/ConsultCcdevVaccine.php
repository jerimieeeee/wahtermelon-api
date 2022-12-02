<?php

namespace App\Models\V1\Childcare;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultCcdevVaccine extends Model
{
    use HasFactory, FilterByUser;

    protected $primaryKey = 'id';
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'vaccine_date' => 'date:Y-m-d',
    ];

}
