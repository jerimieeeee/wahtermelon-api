<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Model;

class LibService extends Model
{
    public $primaryKey = 'id';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;
}
