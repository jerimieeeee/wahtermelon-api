<?php

namespace App\Models\V1\Mortality;

use App\Models\V1\Libraries\LibMortalityDeathPlace;
use App\Models\V1\Libraries\LibMortalityDeathType;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMortality extends Model
{
    use HasFactory, HasUlids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    protected $keyType = 'string';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function deathPlace()
    {
        return $this->belongsTo(LibMortalityDeathPlace::class, 'death_place', 'code');
    }

    public function deathType()
    {
        return $this->belongsTo(LibMortalityDeathType::class, 'death_type', 'code');
    }
}
