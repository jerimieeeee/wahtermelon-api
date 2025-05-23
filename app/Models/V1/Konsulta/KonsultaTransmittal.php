<?php

namespace App\Models\V1\Konsulta;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultaTransmittal extends Model
{
    use HasFactory, HasUuids, FilterByUser, FilterByFacility;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'xml_errors' => 'array',
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

    public function patientPhilhealth()
    {
        return $this->hasManyThrough(Patient::class, PatientPhilhealth::class, 'transmittal_number', 'id', 'transmittal_number', 'patient_id');
    }

    public function patientConsult()
    {
        return $this->hasManyThrough(Patient::class, Consult::class, 'transmittal_number', 'id', 'transmittal_number', 'patient_id');
    }

    public function consult()
    {
        return $this->hasMany(Consult::class, 'transmittal_number', 'transmittal_number');
    }

    public function philhealth()
    {
        return $this->hasMany(PatientPhilhealth::class, 'transmittal_number', 'transmittal_number');
    }

}
