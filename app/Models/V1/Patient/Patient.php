<?php

namespace App\Models\V1\Patient;

use App\Models\User;
use App\Models\V1\Childcare\ConsultCcdev;
use App\Models\V1\Childcare\ConsultCcdevService;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Household\HouseholdFolder;
use App\Models\V1\Household\HouseholdMember;
use App\Models\V1\Libraries\LibPwdType;
use App\Models\V1\Libraries\LibReligion;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use App\Traits\HasSearchFilter;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Patient extends Model
{
    use HasFactory, HasUuids, HasSearchFilter, FilterByUser;

    protected $guarded = [
        'id',
        //'facility_id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        //'birthdate' => 'date:Y-m-d',
        'indegenous_flag' => 'boolean',
        'consent_flag' => 'boolean',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes["last_name"] = ucwords(strtolower($value));
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes["first_name"] = ucwords(strtolower($value));
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes["middle_name"] = ucwords(strtolower($value));
    }

    public function setMothersNameAttribute($value)
    {
        $this->attributes["mothers_name"] = ucwords(strtolower($value));
    }

    public function suffixName(): BelongsTo
    {
        return $this->belongsTo(LibSuffixName::class, 'suffix_name', 'code');
    }

    public function pwdType(): BelongsTo
    {
        return $this->belongsTo(LibPwdType::class, 'pwd_type_code', 'code');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(LibReligion::class, 'religion_code', 'code');
    }

    public function patientMc(): HasMany
    {
        return $this->hasMany(PatientMc::class);
    }

    public function patientccdev()
    {
        return $this->hasOne(PatientCcdev::class);
    }

    public function patientvaccine()
    {
        return $this->hasMany(PatientVaccine::class);
    }

    public function householdFolder()
    {
        return $this->hasOneThrough(HouseholdFolder::class, HouseholdMember::class, 'patient_id', 'id', 'id', 'household_folder_id');
    }

    public function householdMember()
    {
        return $this->hasOne(HouseholdMember::class);
    }

    public function ccdevservices()
    {
        return $this->hasMany(ConsultCcdevService::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consult()
    {
        return $this->hasMany(Consult::class, 'patient_id', 'id');
    }

    public function philhealthLatest()
    {
        return $this->hasOne(PatientPhilhealth::class)
            ->latest('effectivity_year');
    }

    public function patientHistory()
    {
        return $this->hasMany(PatientHistory::class, 'patient_id', 'id')
            ->whereCategory(1);
    }

    public function patientHistorySpecifics()
    {
        return $this->hasMany(PatientHistory::class, 'patient_id', 'id')
            ->whereCategory(1)->whereNotNull('remarks');
    }

    public function familyHistory()
    {
        return $this->hasMany(PatientHistory::class, 'patient_id', 'id')
            ->whereCategory(2);
    }

    public function familyHistorySpecifics()
    {
        return $this->hasMany(PatientHistory::class, 'patient_id', 'id')
            ->whereCategory(2)->whereNotNull('remarks');
    }

    public function surgicalHistory()
    {
        return $this->hasMany(PatientSurgicalHistory::class, 'patient_id', 'id');
    }

    public function socialHistory()
    {
        return $this->hasOne(PatientSocialHistory::class, 'patient_id', 'id');
    }

    public function menstrualHistory()
    {
        return $this->hasOne(PatientMenstrualHistory::class, 'patient_id', 'id');
    }

    public function pregnancyHistory()
    {
        return $this->hasOne(PatientPregnancyHistory::class, 'patient_id', 'id');
    }

    public function ncdRiskAssessmentLatest()
    {
        return $this->hasOne(ConsultNcdRiskAssessment::class, 'patient_id', 'id')
            ->latest('assessment_date');
    }

}
