<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibMortalityDeathPlace extends Model
{
    use HasFactory;

    protected $table = 'lib_mortality_death_place';

    public $primaryKey = 'code';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;
}
