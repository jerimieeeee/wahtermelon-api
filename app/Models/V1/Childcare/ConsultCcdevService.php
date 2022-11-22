<?php

namespace App\Models\V1\Childcare;

use App\Models\V1\Libraries\LibCcdevService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultCcdevService extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $fillable = ['patient_id', 'user_id', 'service_id', 'service_date', 'status_id'];

    protected $casts = [
        'service_date' => 'date:Y-m-d',
    ];

    public function getRouteKeyName()
    {
        return 'patient_id';
    }

    public function patientccdev(){

        return $this->belongsTo(PatientCcdev::class);

    }

    public function patient(){

        return $this->belongsTo(Patient::class, 'patient_id') ;
    }

    public function services(): BelongsTo
    {
        return $this->belongsTo(LibCcdevService::class, 'service_id', 'service_id');
    }
}
