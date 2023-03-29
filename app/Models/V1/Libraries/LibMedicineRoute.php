<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibMedicineRoute extends Model
{
    use HasFactory;

    public $primaryKey = 'code';

    public $timestamps = false;
}
