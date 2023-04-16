<?php

namespace App\Models\V1\Libraries;

use App\Models\V1\Patient\PatientVaccine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibVaccine extends Model
{
    use HasFactory;

    protected $primaryKey = 'vaccine_id';

    public $incrementing = 'false';

    public $keyType = 'string';

    public $timestamps = false;

    // public function vaccines(): BelongsTo
    // {
    //     return $this->belongsTo(PatientVaccine::class);
    // }
}
