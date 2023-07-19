<?php

namespace App\Models\V1\Eclaims;

use App\Models\User;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EclaimsUpload extends Model
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

    public function caserate()
    {
        return $this->hasOne(EclaimsCaserateList::class, 'id', 'eclaims_caserate_list_id');
    }
}
