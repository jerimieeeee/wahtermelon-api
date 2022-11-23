<?php

namespace App\Models\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcService;
use App\Models\V1\Libraries\LibMcVisitType;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class ConsultMcService extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'service_date' => 'date:Y-m-d',
        'positive_result' => 'boolean',
        'intake_penicillin' => 'boolean',
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

    public function service()
    {
        return $this->belongsTo(LibMcService::class, 'service_id');
    }

    public function visitType()
    {
        return $this->belongsTo(LibMcVisitType::class, 'visit_type_code');
    }
}
