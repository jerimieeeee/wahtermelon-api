<?php

namespace App\Models\V1\Consultation;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientVitals;
use App\Traits\FilterByUser;
use DateTime;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Consult extends Model
{
    use HasFactory, FilterByUser;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */

    protected $table='consults';

    protected $primaryKey = 'id';
    protected $guarded = ['id',];

    protected $casts = [
        'consult_date' => 'datetime:Y-m-d H:i:s',
        'is_pregnant' => 'boolean',
        'consult_done' => 'boolean'
    ];

    public function getRouteKeyName()
    {
        return 'patient_id';
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function consultNotes(){
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
            ->join('patient_vitals', function($join){
                $join->on(DB::raw("consults.patient_id"), "=", DB::raw("patient_vitals.patient_id"));
                $join->on(DB::raw("DATE_FORMAT(consults.consult_date, '%Y-%m-%d')"), "=", DB::raw("DATE_FORMAT(patient_vitals.vitals_date, '%Y-%m-%d')"));
            })
            ->orderBy('vitals_date', 'DESC');
    }

}
