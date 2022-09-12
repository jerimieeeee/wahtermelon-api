<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LibOccupationCategory extends Model
{
    use HasFactory;

    public $primaryKey = 'category_code';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = false;

    public function occupation(): HasMany
    {
        return $this->hasMany(LibOccupation::class, 'category_code', 'category_code');
    }

}
