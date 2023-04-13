<?php

namespace App\Models\V1\TBDots;

use App\Models\V1\Libraries\LibTbTreatmentOutcome;
use App\Models\V1\TBDots\PatientTbCaseFinding;
use App\Models\V1\Libraries\LibTbOutcomeReason;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTb extends Model
{
    use HasFactory, HasUlids, FilterByUser;

    protected $guarded = [
        'id'
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

    public function treatmentOutcome()
    {
        return $this->belongsTo(LibTbTreatmentOutcome::class, 'tb_treatment_outcome_code', 'code');
    }

    public function outcomeReason()
    {
        return $this->belongsTo(LibTbOutcomeReason::class, 'lib_tb_outcome_reason_id', 'id');
    }

    public function tbCaseFinding()
    {
        return $this->hasOne(PatientTbCaseFinding::class, 'patient_tb_id', 'id');
    }

    public function tbSymptom()
    {
        return $this->hasOne(PatientTbSymptom::class, 'patient_tb_id', 'id');
    }

    public function tbPhysicalExam()
    {
        return $this->hasOne(PatientTbPe::class, 'patient_tb_id', 'id');
    }

    public function tbCaseHolding(){
        return $this->hasOne(PatientTbCaseHolding::class, 'patient_tb_id', 'id');
    }
}
