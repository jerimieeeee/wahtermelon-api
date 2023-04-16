<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibPtGroup extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = 'false';

    public $keyType = 'string';

    public $timestamps = false;
}
