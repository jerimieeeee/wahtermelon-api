<?php

namespace App\Models\V1\Patient;

use App\Models\User;
use App\Models\V1\Childcare\ConsultCcdevService;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
use App\Models\V1\Household\HouseholdFolder;
use App\Models\V1\Household\HouseholdMember;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Libraries\LibPwdType;
use App\Models\V1\Libraries\LibReligion;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\MaternalCare\PatientMc;
use App\Models\V1\Medicine\MedicinePrescription;
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
use Illuminate\Support\Facades\DB;

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
                        'patient_respiratory_rate',
                        'vitals_date'
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

    public function medicine()
    {
        return $this->hasMany(MedicinePrescription::class, 'patient_id', 'id')
            ->join('lib_konsulta_medicines', function ($join) {
                $join->on('medicine_prescriptions.konsulta_medicine_code', '=', 'lib_konsulta_medicines.code')
                    ->orOn(DB::raw('medicine_prescriptions.konsulta_medicine_code IS NULL'), '=', DB::raw('true'));
            })
            ->leftJoin('lib_medicines', 'medicine_prescriptions.medicine_code', '=', 'lib_medicines.hprodid')
            ->join('lib_medicine_unit_of_measurements', 'medicine_prescriptions.dosage_uom', '=', 'lib_medicine_unit_of_measurements.code')
            ->join('lib_medicine_dose_regimens', 'medicine_prescriptions.dose_regimen', '=', 'lib_medicine_dose_regimens.code')
            ->join('lib_medicine_purposes', 'medicine_prescriptions.medicine_purpose', '=', 'lib_medicine_purposes.code')
            ->join('lib_medicine_duration_frequencies', 'medicine_prescriptions.duration_frequency', '=', 'lib_medicine_duration_frequencies.code')
            ->join('lib_medicine_preparations', 'medicine_prescriptions.quantity_preparation', '=', 'lib_medicine_preparations.code')
            ->leftJoin('lib_medicine_routes', 'medicine_prescriptions.medicine_route_code', '=', 'lib_medicine_routes.code')
//            ->leftJoin('medicine_dispensings', 'medicine_prescriptions.id', '=', 'medicine_dispensings.prescription_id')
            ->select([
                'medicine_prescriptions.patient_id',
                DB::raw("CASE
                        WHEN medicine_prescriptions.konsulta_medicine_code IS NOT NULL THEN lib_konsulta_medicines.desc
                        WHEN medicine_prescriptions.medicine_code IS NOT NULL THEN lib_medicines.drug_name
                        ELSE added_medicine
                    END AS medicine"),
                'lib_medicine_unit_of_measurements.desc AS measurement',
                'lib_medicine_dose_regimens.desc AS dose_regimen',
                DB::raw("CONCAT(medicine_prescriptions.duration_intake, ' ', lib_medicine_duration_frequencies.desc, '/', 's') as duration"),
                DB::raw("CONCAT(medicine_prescriptions.quantity, ' ', lib_medicine_preparations.desc, '/', 's') as quantity_and_preparation"),
                'lib_medicine_purposes.desc AS purpose'
            ])
            ->groupBy('medicine');
    }

//    public function medicine()
//    {
//        return $this->hasMany(MedicinePrescription::class, 'patient_id', 'id')
//            ->join('lib_konsulta_medicines', 'medicine_prescriptions.konsulta_medicine_code', '=', 'lib_konsulta_medicines.code')
//            ->leftJoin('lib_medicines', 'medicine_prescriptions.medicine_code', '=', 'lib_medicines.hprodid')
//            ->join('lib_medicine_unit_of_measurements', 'medicine_prescriptions.dosage_uom', '=' , 'lib_medicine_unit_of_measurements.code')
//            ->join('lib_medicine_dose_regimens', 'medicine_prescriptions.dose_regimen', '=' , 'lib_medicine_dose_regimens.code')
//            ->join('lib_medicine_purposes', 'medicine_prescriptions.medicine_purpose' , '=' , 'lib_medicine_purposes.code')
//            ->join('lib_medicine_duration_frequencies', 'medicine_prescriptions.duration_frequency' , '=' , 'lib_medicine_duration_frequencies.code')
//            ->join('lib_medicine_preparations', 'medicine_prescriptions.quantity_preparation' , '=' , 'lib_medicine_preparations.code')
//            ->join('lib_medicine_routes', 'medicine_prescriptions.medicine_route_code' , '=' , 'lib_medicine_routes.code')
//            ->select(['patient_id',
//                      'lib_konsulta_medicines.desc AS medicine',
//                      'lib_medicine_unit_of_measurements.desc AS measurement',
//                      'lib_medicine_dose_regimens.desc AS dose_regimen',
//                      DB::raw("CONCAT(medicine_prescriptions.duration_intake, ' ', lib_medicine_duration_frequencies.desc, '/', 's') as duration"),
//                      DB::raw("CONCAT(medicine_prescriptions.quantity, ' ', lib_medicine_preparations.desc) as quantity_and_preparation"),
//                      'lib_medicine_purposes.desc AS purpose'
//                ]);
//    }
}
