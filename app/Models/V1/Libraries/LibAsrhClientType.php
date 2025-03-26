<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibAsrhClientType extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';

    public $incrementing = 'false';

    public $keyType = 'string';

    public $timestamps = false;
}
