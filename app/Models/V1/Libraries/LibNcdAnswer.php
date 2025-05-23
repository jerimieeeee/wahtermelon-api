<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibNcdAnswer extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $timestamps = false;

    public $keyType = 'string';

    protected $guarded = [
        'id',
    ];
}
