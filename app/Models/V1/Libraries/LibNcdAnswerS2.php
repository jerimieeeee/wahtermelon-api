<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibNcdAnswerS2 extends Model
{
    use HasFactory;

    protected $table = 'lib_ncd_answer_s2';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public $keyType = 'string';

    protected $guarded = [
        'id',
    ];
}
