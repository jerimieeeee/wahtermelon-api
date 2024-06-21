<?php

namespace App\Models\V1\Patient;

use App\Models\User;
use App\Models\V1\Childcare\ConsultCcdevService;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Consultation\ConsultNotes;
use App\Models\V1\Consultation\ConsultNotesComplaint;
use App\Models\V1\Consultation\ConsultNotesFinalDx;
use App\Models\V1\Consultation\ConsultNotesInitialDx;
use App\Models\V1\Consultation\ConsultNotesPe;
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

    public function philhealth_id()
    {
        return $this->hasMany(PatientPhilhealth::class, 'patient_id', 'id')
            ->select(['patient_id', 'philhealth_id']);
    }

    public function consultNotes()
    {
        return $this->hasMany(ConsultNotes::class, 'patient_id', 'id');
//            ->select(['patient_id', 'complaint', 'history', 'plan']);
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
            )
            ->groupBy('vitals_date')
            ->orderBy('vitals_date');
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

    public function vitalsLatest()
    {
        /*return $this->hasMany(PatientVitals::class, 'patient_id', 'patient_id')
                ->selectRaw('patient_vitals.*')
                ->join('consults', function($join){
                    $join->on(DB::raw("consults.patient_id"), "=", DB::raw("patient_vitals.patient_id"));
                    $join->on(DB::raw("DATE_FORMAT(consults.consult_date, '%Y-%m-%d')"), "=", DB::raw("DATE_FORMAT(patient_vitals.vitals_date, '%Y-%m-%d')"));
                })
                ->orderBy('vitals_date', 'DESC');*/
        return $this->hasOne(Consult::class, 'id', 'id')
            ->selectRaw('
                consults.id,
                patient_vitals.id as vitals_id,
                patient_vitals.facility_code,
                patient_vitals.patient_id,
                patient_vitals.user_id,
                vitals_date,
                patient_age_years,
                patient_age_months,
                patient_temp,
                patient_height,
                patient_weight,
                patient_bmi,
                patient_bmi_class,
                patient_weight_for_age,
                patient_height_for_age,
                patient_weight_for_height,
                patient_head_circumference,
                patient_skinfold_thickness,
                bp_systolic,
                bp_diastolic,
                patient_heart_rate,
                patient_respiratory_rate,
                patient_pulse_rate,
                patient_spo2,
                patient_chest,
                patient_abdomen,
                patient_waist,
                patient_hip,
                patient_limbs,
                patient_muac,
                patient_vitals.created_at,
                patient_vitals.updated_at
            ')
            ->join('patient_vitals', function ($join) {
                $join->on(DB::raw('consults.patient_id'), '=', DB::raw('patient_vitals.patient_id'));
                $join->on(DB::raw("DATE_FORMAT(consults.consult_date, '%Y-%m-%d')"), '=', DB::raw("DATE_FORMAT(patient_vitals.vitals_date, '%Y-%m-%d')"));
            })
            ->orderBy('vitals_date', 'DESC');
    }

    public function complaints()
    {
        return $this->belongsTo(ConsultNotesComplaint::class, 'patient_id', 'id');
    }

    public function physicalExam()
    {
        return $this->hasManyThrough(ConsultNotesPe::class, ConsultNotes::class, 'patient_id', 'notes_id', 'id', 'id');
    }

    public function consult_no_fdx()
    {
        return $this->hasMany(Consult::class, 'patient_id', 'id')
            ->whereDoesntHave('finalDiagnosis');
    }

    public function patient_vitals()
    {
        return $this->hasOne(Consult::class, 'patient_id', 'id')
            ->selectRaw('
                patient_vitals.patient_id AS patient_id,
                bp_systolic,
                bp_diastolic,
                patient_bmi,
                patient_bmi_class,
                patient_weight,
                patient_height,
                patient_waist,
                patient_temp,
                patient_heart_rate,
                patient_respiratory_rate,
                patient_pulse_rate
            ')
            ->join('patient_vitals', function ($join) {
                $join->on(DB::raw('consults.patient_id'), '=', DB::raw('patient_vitals.patient_id'));
                $join->on(DB::raw('consults.id'), '=', DB::raw('patient_vitals.consult_id'));
                $join->on(DB::raw("DATE_FORMAT(consults.consult_date, '%Y-%m-%d')"), '=', DB::raw("DATE_FORMAT(patient_vitals.vitals_date, '%Y-%m-%d')"));
            })
            ->orderBy('vitals_date', 'DESC');
    }

    public function initialdx()
    {
        return $this->hasMany(ConsultNotes::class, 'patient_id', 'id')
            ->leftJoin('consult_notes_initial_dxes', function ($join) {
                $join->on('consult_notes.id', '=', 'consult_notes_initial_dxes.notes_id');
            })
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->leftJoin('lib_diagnoses', 'consult_notes_initial_dxes.class_id', '=', 'lib_diagnoses.class_id')
            ->select([
                'consult_notes.patient_id AS patient_id',
                'lib_diagnoses.class_name AS diagnosis_name'
            ]);
    }

    public function finaldx()
    {
        return $this->hasMany(ConsultNotes::class, 'patient_id', 'id')
            ->leftJoin('consult_notes_final_dxes', function ($join) {
            $join->on('consult_notes.id', '=', 'consult_notes_final_dxes.notes_id');
        })
        ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
        ->leftJoin('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
        ->select([
            'consult_notes.consult_id',
            'consult_notes.id',
            'consult_notes.patient_id AS patient_id',
            'consults.consult_date AS consult_date',
            'consult_notes_final_dxes.icd10_code AS icd10_code',
            'lib_icd10s.icd10_desc AS icd10_desc'
        ]);
    }

    public function consultpe()
    {
        return $this->hasMany(ConsultNotes::class, 'patient_id', 'id');
    }
}
