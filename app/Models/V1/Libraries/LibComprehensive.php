<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibComprehensive extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';

    public $incrementing = 'false';

    public $keyType = 'string';

    public $timestamps = false;

    public function questions()
    {
        return $this->hasMany(LibComprehensiveQuestionnaire::class, 'lib_comprehensive_code', 'code');
    }
}
