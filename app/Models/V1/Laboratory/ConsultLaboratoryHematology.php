<?php

namespace App\Models\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibBloodType;
use App\Models\V1\Libraries\LibLaboratoryStatus;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultLaboratoryHematology extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, HasUuids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'laboratory_date' => 'date:Y-m-d',
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

    public function consult()
    {
        return $this->belongsTo(Consult::class);
    }

    public function bloodType()
    {
        return $this->belongsTo(LibBloodType::class, 'blood_type_code', 'code');
    }

    public function laboratoryRequest()
    {
        return $this->belongsTo(ConsultLaboratory::class, 'request_id', 'id');
    }

    public function laboratoryStatus()
    {
        return $this->belongsTo(LibLaboratoryStatus::class, 'lab_status_code', 'code');
    }

    public function setBloodTypeCodeAttribute($value)
    {
        $this->attributes['blood_type_code'] = $value ?? 'NA';
    }
}
