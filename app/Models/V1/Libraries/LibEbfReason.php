<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibEbfReason extends Model
{
    use HasFactory;

    protected $primaryKey = 'reason_id';
    public $incrementing = 'false';
    public $keyType = 'string';
}
