<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibMcRiskFactor extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'hospital_flag' => 'boolean',
        'monitor_flag' => 'boolean',
    ];
}
