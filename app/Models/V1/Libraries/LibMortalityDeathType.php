<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibMortalityDeathType extends Model
{
    use HasFactory;
    protected $table = 'lib_mortality_death_type';

    public $primaryKey = 'code';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;
}
