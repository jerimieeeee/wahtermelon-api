<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Model;

class LibGenderIdentity extends Model
{
    public $primaryKey = 'code';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;
}
