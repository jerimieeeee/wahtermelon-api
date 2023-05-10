<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibAnswerYnx extends Model
{
    use HasFactory;

    protected $table = 'lib_answer_ynx';

    public $primaryKey = 'code';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;
}
