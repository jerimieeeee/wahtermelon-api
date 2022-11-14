<?php

namespace App\Models\V1\MaternalCare;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultMcPrenatal extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';
}
