<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibNcdEyeReferProfessional extends Model
{
    protected $table = 'lib_ncd_eye_refer_professionals';

    use HasFactory;

    public $keyType = 'string';

    protected $primaryKey = 'code';

    public $timestamps = false;

    protected $guarded = [
        'code',
    ];
}
