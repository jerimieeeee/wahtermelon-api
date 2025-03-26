<?php

namespace App\Models\V1\Adolescent;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibAsrhLivingArrangementType;
use App\Models\V1\Libraries\LibAsrhRefusalReason;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Patient::class);
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

}
