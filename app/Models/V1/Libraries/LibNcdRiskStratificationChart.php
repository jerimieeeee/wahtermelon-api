<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibNcdRiskStratificationChart extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'smoking_status' => 'boolean',
        'diabetes_present' => 'boolean',
    ];
}
