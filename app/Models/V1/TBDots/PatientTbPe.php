<?php

namespace App\Models\V1\TBDots;

use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTbPe extends Model
{
    use HasFactory, HasUlids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    protected $keyType = 'string';

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }
}
