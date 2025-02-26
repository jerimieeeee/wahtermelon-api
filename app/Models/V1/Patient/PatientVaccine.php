<?php

namespace App\Models\V1\Patient;

use App\Models\V1\Libraries\LibVaccine;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientVaccine extends Model
{
    use SoftDeletes ,HasFactory, FilterByUser;

    protected $guarded = [
        'id',
    ];

    //protected $fillable = ['patient_id', 'user_id', 'facility_code', 'vaccine_id', 'vaccine_date', 'status_id'];

    protected $casts = [
        'vaccine_date' => 'date:Y-m-d',
    ];

    public function getRouteKeyName()
    {
        return 'patient_id';
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id')
            ->select(['id', 'immunization_status', 'immunization_date']);
    }

    public function vaccines(): BelongsTo
    {
        return $this->belongsTo(LibVaccine::class, 'vaccine_id', 'vaccine_id');
    }
}
