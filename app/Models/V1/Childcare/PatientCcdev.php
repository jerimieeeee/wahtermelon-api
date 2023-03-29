<?php

namespace App\Models\V1\Childcare;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientCcdev extends Model
{
    use SoftDeletes, HasFactory, FilterByUser;

    protected $fillable = ['patient_id', 'user_id', 'birth_weight', 'ccdev_ended', 'mothers_id', 'admission_date', 'discharge_date', 'nbs_filter'];

    protected $casts = [
        'admission_date' => 'datetime:Y-m-d H:i:s',
        'discharge_date' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'patient_id';
    }

    public function consultccdev()
    {
        return $this->hasOne(PatientCcdev::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function consultccdevbfed()
    {
        return $this->hasOne(ConsultCcdevBreastfed::class);
    }
}
