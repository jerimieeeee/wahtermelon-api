<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibCcdevService extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';

    public $incrementing = 'false';

    public $keyType = 'string';

    public $timestamps = false;
}
