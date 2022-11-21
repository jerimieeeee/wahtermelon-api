<?php

namespace App\Models\V1\MaternalCare;

use App\Models\User;
use App\Models\V1\Libraries\LibMcAttendant;
use App\Models\V1\Libraries\LibMcDeliveryLocation;
use App\Models\V1\Libraries\LibMcOutcome;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientMcPostRegistration extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'post_registration_date' => 'date:Y-m-d',
        'admission_date' => 'datetime:Y-m-d H:i:s',
        'discharge_date' => 'datetime:Y-m-d H:i:s',
        'delivery_date' => 'datetime:Y-m-d H:i:s',
        'breastfed_date' => 'date:Y-m-d H:i:s',
        'healthy_baby' => 'boolean',
        'breastfeeding' => 'boolean',
        'end_pregnancy' => 'boolean',
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

    public function patientMc()
    {
        return $this->belongsTo(PatientMc::class, 'patient_mc_id', 'id');
    }

    public function deliveryLocation()
    {
        return $this->belongsTo(LibMcDeliveryLocation::class);
    }

    public function outcome()
    {
        return $this->belongsTo(LibMcOutcome::class);
    }

    public function attendant()
    {
        return $this->belongsTo(LibMcAttendant::class);
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'code');
    }
}
