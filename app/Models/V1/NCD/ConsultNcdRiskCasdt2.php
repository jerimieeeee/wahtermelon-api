<?php

namespace App\Models\V1\NCD;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibNcdEyeRefer;
use App\Models\V1\Libraries\LibNcdEyeReferProfessional;
use App\Models\V1\Libraries\LibNcdEyeVisionScreening;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class ConsultNcdRiskCasdt2 extends Model
{
    use HasFactory, HasUlids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function consultRiskAssessment()
    {
        return $this->belongsTo(ConsultNcdRiskAssessment::class, 'consult_ncd_risk_id', 'id');
    }

    public function patientNcd()
    {
        return $this->belongsTo(PatientNcd::class, 'patient_ncd_id', 'id');
    }

    public function consult()
    {
        return $this->belongsTo(Consult::class, 'consult_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function eyeRefer()
    {
        return $this->belongsTo(LibNcdEyeRefer::class, 'eye_refer', 'code');
    }

    public function unaided()
    {
        return $this->belongsTo(LibNcdEyeVisionScreening::class, 'unaided', 'code');
    }

    public function pinhole()
    {
        return $this->belongsTo(LibNcdEyeVisionScreening::class, 'pinhole', 'code');
    }

    public function improved()
    {
        return $this->belongsTo(LibNcdEyeVisionScreening::class, 'improved', 'code');
    }

    public function aided()
    {
        return $this->belongsTo(LibNcdEyeVisionScreening::class, 'aided', 'code');
    }

    public function eyeReferProf()
    {
        return $this->belongsTo(LibNcdEyeReferProfessional::class, 'eye_refer_prof', 'code');
    }

    public function casdt2Vision()
    {
        return $this->belongsTo(ConsultNcdRiskCasdt2Vision::class, 'casdt2_id', 'id');
    }
}
