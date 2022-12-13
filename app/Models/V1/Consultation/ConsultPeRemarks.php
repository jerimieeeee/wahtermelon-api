<?php

namespace App\Models\V1\Consultation;

use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultPeRemarks extends Model
{
    use HasFactory, HasUuid, FilterByUser;

    protected $keyType = 'string';

    protected $guarded = [
        'id'
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

}
