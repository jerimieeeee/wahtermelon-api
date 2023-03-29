<?php

namespace App\Models\V1\Childcare;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultCcdev extends Model
{
    use HasFactory, FilterByUser;

    protected $guarded = ['id'];

    protected $casts = [
        'visit_date' => 'date:Y-m-d',
    ];

    public function patientccdev()
    {
        return $this->belongsTo(PatientCcdev::class);
    }
}
