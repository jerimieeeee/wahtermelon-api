<?php

namespace App\Models\V1\Libraries;

use App\Traits\HasSearchFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibIcd10 extends Model
{
    use HasFactory, HasSearchFilter;

    protected $primaryKey = 'icd10_code';

    public $incrementing = 'false';

    public $keyType = 'string';

    public $timestamps = false;
}
