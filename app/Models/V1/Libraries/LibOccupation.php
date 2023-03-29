<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibOccupation extends Model
{
    use HasFactory;

    public $primaryKey = 'code';

    public $incrementing = false;

    public $keyType = 'string';

    public $timestamps = false;

    public function occupationCategory(): BelongsTo
    {
        return $this->belongsTo(LibOccupationCategory::class, 'category_code', 'code');
    }
}
