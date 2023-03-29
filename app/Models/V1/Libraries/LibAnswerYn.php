<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibAnswerYn extends Model
{
    use HasFactory;

    protected $table = 'lib_answer_yn';

    public $primaryKey = 'code';
    public $increment = false;
    public $keyType = 'string';
    public $timestamps = false;

}
