<?php

namespace App\Models\V1\Patient;

use App\Models\User;
use App\Models\V1\Libraries\LibService;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientService extends Model
{
    /** @use HasFactory<\Database\Factories\V1\Patient\PatientServiceFactory> */
    use HasFactory, HasUlids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'service_date' => 'datetime:Y-m-d',
        'quantity' => 'integer',
    ];

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

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function libService()
    {
        return $this->belongsTo(LibService::class, 'lib_service_id', 'id');
    }
}
