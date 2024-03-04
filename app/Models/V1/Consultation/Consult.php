<?php

namespace App\Models\V1\Consultation;

use App\Models\User;
use App\Models\V1\Konsulta\KonsultaTransmittal;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Medicine\MedicineDispensing;
use App\Models\V1\Medicine\MedicinePrescription;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
use App\Models\V1\Patient\PatientVitals;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Consult extends Model
{
    use HasFactory, FilterByUser, FilterByFacility;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'consults';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $casts = [
        'consult_date' => 'datetime:Y-m-d H:i:s',
        'is_pregnant' => 'boolean',
        'is_konsulta' => 'boolean',
        'consult_done' => 'boolean',
        'walkedin_status' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'patient_id';
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function consultNotes()
    {
        return $this->hasOne(ConsultNotes::class, 'consult_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function complaints()
    {
        return $this->belongsTo(ConsultNotesComplaint::class);
    }

    public function initialdx()
    {
        return $this->belongsTo(ConsultNotesInitialDx::class);
    }

    public function finaldx()
    {
        return $this->belongsTo(ConsultNotesFinalDx::class);
    }

    public function physician()
    {
        return $this->belongsTo(User::class, 'physician_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function vitals()
    {
        /*return $this->hasMany(PatientVitals::class, 'patient_id', 'patient_id')
                ->selectRaw('patient_vitals.*')
                ->join('consults', function($join){
                    $join->on(DB::raw("consults.patient_id"), "=", DB::raw("patient_vitals.patient_id"));
                    $join->on(DB::raw("DATE_FORMAT(consults.consult_date, '%Y-%m-%d')"), "=", DB::raw("DATE_FORMAT(patient_vitals.vitals_date, '%Y-%m-%d')"));
                })
                ->orderBy('vitals_date', 'DESC');*/
        return $this->hasMany(Consult::class, 'id', 'id')
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

    public function philhealthLatest()
    {
        return $this->hasOne(PatientPhilhealth::class, 'patient_id', 'patient_id')
            ->latest('effectivity_year');
    }

    public function finalDiagnosis()
    {
        return $this->hasManyThrough(ConsultNotesFinalDx::class, ConsultNotes::class, 'consult_id', 'notes_id', 'id', 'id');
    }

    public function consultLaboratory()
    {
        return $this->hasMany(ConsultLaboratory::class, 'consult_id', 'id');
    }

    public function prescription()
    {
        return $this->hasMany(MedicinePrescription::class, 'consult_id', 'id');
    }

    public function management()
    {
        return $this->hasManyThrough(ConsultNotesManagement::class, ConsultNotes::class, 'consult_id', 'notes_id', 'id', 'id');
    }

    public function konsultaTransmittal()
    {
        return $this->hasMany(KonsultaTransmittal::class, 'transmittal_number', 'transmittal_number');
    }

    public function medicine()
    {
        return $this->hasManyThrough(MedicineDispensing::class, MedicinePrescription::class, 'consult_id', 'prescription_id', 'id', 'id');
    }
}
