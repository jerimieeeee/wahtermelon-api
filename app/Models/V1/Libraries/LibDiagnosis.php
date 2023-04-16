<?php

namespace App\Models\V1\Libraries;

use App\Traits\HasSearchFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibDiagnosis extends Model
{
    use HasFactory, HasSearchFilter;

    protected $primaryKey = 'class_id';

    public $incrementing = 'false';

    public $keyType = 'string';

    public $timestamps = false;
}
