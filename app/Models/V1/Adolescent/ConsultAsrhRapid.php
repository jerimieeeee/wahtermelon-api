<?php

namespace App\Models\V1\Adolescent;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibAsrhClientType;
use App\Models\V1\Libraries\LibAsrhLivingArrangementType;
use App\Models\V1\Libraries\LibAsrhRefusalReason;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientVitals;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConsultAsrhRapid extends Model
{
    /** @use HasFactory<\Database\Factories\V1\Adolescent\ConsultAsrhRapidFactory> */
    use HasFactory, HasUlids, FilterByUser, FilterByFacility, CascadeSoftDeletes;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $cascadeDeletes = [
        'answers',
        'comprehensive',
    ];

    protected $casts = [
        'assessment_date' => 'date:Y-m-d',
        'done_date' => 'date:Y-m-d',
        'referral_date' => 'date:Y-m-d',
        'consent_flag' => 'boolean',
        'refused_flag' => 'boolean',
        'done_flag' => 'boolean',
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
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(ConsultAsrhRapidAnswer::class);
    }

    public function comprehensive()
    {
        return $this->hasOne(ConsultAsrhComprehensive::class);
    }

    public function referToUser()
    {
        return $this->belongsTo(User::class, 'refer_to_user_id');
    }

    public function refusalReason()
    {
        return $this->belongsTo(LibAsrhRefusalReason::class, 'lib_asrh_refusal_reason_id');
    }

    public function livingArrangementType()
    {
        return $this->belongsTo(LibAsrhLivingArrangementType::class, 'lib_asrh_living_arrangement_type_id');
    }

    public function consult()
    {
        return $this->belongsTo(Consult::class, 'patient_id', 'patient_id')
            ->where('consults.pt_group', '=', 'cn');
    }

    public function clientTypes()
    {
        return $this->belongsTo(LibAsrhClientType::class, 'lib_asrh_client_type_code', 'code');
    }

    public function vitalsAsrh()
    {
        return $this->hasOne(PatientVitals::class, 'patient_id', 'patient_id')
            ->select([
                'vitals_date',
                'patient_height',
                'patient_weight',
                'patient_bmi',
                'patient_bmi_class',
                'bp_systolic',
                'bp_diastolic',
                'patient_heart_rate'
            ])
            ->whereRaw("DATE_FORMAT(vitals_date, '%Y-%m-%d') = ?", [
                $this->assessment_date?->format('Y-m-d')
            ])
            ->orderBy('vitals_date', 'desc')->latest();
    }

    public function answersQuestion3()
    {
        return $this->hasOne(ConsultAsrhRapidAnswer::class)
            ->select([
                'consult_asrh_rapid_id',
                'lib_rapid_questionnaire_id',
                'answer'
            ])
            ->where('lib_rapid_questionnaire_id', '=', '3');
    }
}
