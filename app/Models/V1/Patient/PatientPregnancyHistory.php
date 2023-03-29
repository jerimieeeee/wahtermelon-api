<?php

namespace App\Models\V1\Patient;

use App\Models\V1\Libraries\LibNcdAnswerS2;
use App\Models\V1\Libraries\LibPregnancyDeliveryType;
use App\Models\V1\Libraries\LibPregnancyHistoryAnswer;
use App\Models\V1\MaternalCare\PatientMcPostRegistration;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPregnancyHistory extends Model
{
    use HasFactory, HasUuids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

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

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function postPartum()
    {
        return $this->belongsTo(PatientMcPostRegistration::class, 'post_partum_id', 'id');
    }

    public function libPregnancyDeliveryType()
    {
        return $this->belongsTo(LibPregnancyDeliveryType::class, 'delivery_type', 'code');
    }

    public function libPregnancyHistoryAnswer()
    {
        return $this->belongsTo(LibPregnancyHistoryAnswer::class, 'code', 'code');
    }

    public function inducedHypertension()
    {
        return $this->belongsTo(LibNcdAnswerS2::class, 'induced_hypertension', 'id');
    }

    public function withFamilyPlanning()
    {
        return $this->belongsTo(LibNcdAnswerS2::class, 'with_family_planning', 'id');
    }
}
