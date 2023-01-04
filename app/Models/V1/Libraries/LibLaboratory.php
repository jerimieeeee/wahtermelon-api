<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibLaboratory extends Model
{
    use HasFactory;

    public $primaryKey = 'code';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = false;

    protected $casts = [
        'lab_active' => 'boolean',
        'konsulta_active' => 'boolean',
    ];

    public function category()
    {
        return $this->hasMany(LibLaboratoryCategory::class, 'lab_code', 'code');
    }
}
