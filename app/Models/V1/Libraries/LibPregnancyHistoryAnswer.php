<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibPregnancyHistoryAnswer extends Model
{
    use HasFactory;

    public $primaryKey = 'id';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;
}
