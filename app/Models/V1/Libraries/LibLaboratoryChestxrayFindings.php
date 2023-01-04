<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibLaboratoryChestxrayFindings extends Model
{
    use HasFactory;

    public $primaryKey = 'code';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = false;

    protected $casts = [
        'library_status' => 'boolean',
    ];
}
