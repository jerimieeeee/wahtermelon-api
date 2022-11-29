<?php

namespace App\Models\V1\Consultation;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientVitals;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Consult extends Model
{
    use HasFactory;

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

    public function consult_notes(){
        return $this->hasOne(ConsultNotes::class, 'consult_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->hasMany(PatientVitals::class, 'patient_id', 'patient_id')
                ->selectRaw('patient_vitals.*')
                ->join('consults', function($join){
                    $join->on(DB::raw("consults.patient_id"), "=", DB::raw("patient_vitals.patient_id"));
                    $join->on(DB::raw("DATE_FORMAT(consults.consult_date, '%Y-%m-%d')"), "=", DB::raw("DATE_FORMAT(patient_vitals.vitals_date, '%Y-%m-%d')"));
                })
                ->orderBy('vitals_date', 'DESC');
    }

}
