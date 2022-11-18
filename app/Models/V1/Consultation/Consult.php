<?php

namespace App\Models\V1\Consultation;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use DateTime;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Consult extends Model
{
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

}
