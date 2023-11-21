<?php

namespace App\Models\V1\Patient;

use App\Models\User;
use App\Models\V1\Childcare\ConsultCcdevService;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesComplaint;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
use App\Models\V1\Household\HouseholdFolder;
use App\Models\V1\Household\HouseholdMember;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibPwdType;
use App\Models\V1\Libraries\LibReligion;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use App\Traits\HasSearchFilter;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory, HasUuids, HasSearchFilter, FilterByUser; //, FilterByFacility;

    protected $guarded = [
        'id',
        //'facility_id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'birthdate' => 'date:Y-m-d',
        'indegenous_flag' => 'boolean',
        'consent_flag' => 'boolean',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords(strtolower($value));
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords(strtolower($value));
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = ucwords(strtolower($value));
    }

    public function setMothersNameAttribute($value)
    {
        $this->attributes['mothers_name'] = ucwords(strtolower($value));
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
        return $this->hasOne(PatientPhilhealth::class, 'patient_id', 'id')
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

    public function consultLaboratory()
    {
        return $this->hasMany(ConsultLaboratory::class, 'patient_id', 'id');
    }

    public function philhealth()
    {
        return $this->hasMany(PatientPhilhealth::class, 'patient_id', 'id');
    }

    public function pastPatientHistory()
    {
        return $this->hasMany(PatientHistory::class, 'patient_id', 'id');
    }

    public function patientVitals()
    {
        return $this->hasMany(PatientVitals::class, 'patient_id', 'id');
    }

    public function patientWashington()
    {
        return $this->hasOne(PatientWashingtonQuestion::class, 'patient_id', 'id');
    }

    public function philhealthKonsulta()
    {
        return $this->hasOne(PhilhealthCredential::class, 'facility_code', 'facility_code')->whereProgramCode('kp');
    }

    public function initial_dx()
    {
        return $this->hasManyThrough(ConsultNotesInitialDx::class, ConsultNotes::class, 'patient_id', 'notes_id', 'id', 'id')
            ->select(['class_id']);
    }

    public function final_dx()
    {
        return $this->hasManyThrough(ConsultNotesFinalDx::class, ConsultNotes::class, 'patient_id', 'notes_id', 'id', 'id')
            ->select(['icd10_code']);
    }

    public function philhealth_id()
    {
        return $this->hasMany(PatientPhilhealth::class, 'patient_id', 'id')
            ->select(['patient_id', 'philhealth_id']);;
    }

    public function consult_notes()
    {
        return $this->hasMany(ConsultNotes::class, 'patient_id', 'id')
            ->select(['patient_id', 'complaint', 'history', 'plan']);
    }

    public function vitals()
    {
        return $this->hasMany(PatientVitals::class, 'patient_id', 'id')
            ->select('patient_id',
                        'bp_systolic',
                        'bp_diastolic',
                        'patient_temp',
                        'patient_weight',
                        'patient_height',
                        'patient_pulse_rate',
                        'patient_heart_rate',
                        'patient_respiratory_rate'
            );
    }

    public function consults()
    {
        return $this->hasMany(Consult::class, 'patient_id', 'id')
            ->select(['patient_id', 'consult_date']);
    }

    public function address()
    {
        return $this->hasManyThrough(HouseholdFolder::class, HouseholdMember::class, 'patient_id', 'id', 'id', 'household_folder_id')
            ->select(['address', 'barangay_code']);
    }
}
