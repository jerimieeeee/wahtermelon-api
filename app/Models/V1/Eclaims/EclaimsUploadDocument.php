<?php

namespace App\Models\V1\Eclaims;

use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EclaimsUploadDocument extends Model
{
    use HasFactory, FilterByUser, FilterByFacility, HasUlids;

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

    public function caserate()
    {
        return $this->hasOne(EclaimsCaserateList::class, 'id', 'eclaims_caserate_list_id');
    }
}
