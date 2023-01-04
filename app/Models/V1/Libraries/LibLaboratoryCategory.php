<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibLaboratoryCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'field_active' => 'boolean',
    ];

    public function laboratory()
    {
        return $this->belongsTo(LibLaboratory::class, 'lab_code', 'code');
    }
}
