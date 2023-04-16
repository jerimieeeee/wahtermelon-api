<?php

namespace App\Models\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcLocation;
use App\Models\V1\Libraries\LibMcPresentation;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultMcPrenatal extends Model
{
    use HasFactory, SoftDeletes, HasUuid, FilterByUser;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'prenatal_date' => 'date:Y-m-d',
        'private' => 'boolean',
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

    public function patientMc()
    {
        return $this->belongsTo(PatientMc::class);
    }

    public function presentation()
    {
        return $this->belongsTo(LibMcPresentation::class);
    }

    public function location()
    {
        return $this->belongsTo(LibMcLocation::class);
    }
}
