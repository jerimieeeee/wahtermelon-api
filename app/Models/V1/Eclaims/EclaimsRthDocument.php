<?php

namespace App\Models\V1\Eclaims;

use Illuminate\Database\Eloquent\Model;

class EclaimsRthDocument extends Model
{
    use HasFactory, FilterByUser, FilterByFacility;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
