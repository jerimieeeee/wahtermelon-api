<?php

namespace App\Models\V1\Childcare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultCcdevService extends Model
{
    protected $guarded = [
        ' id',
    ];

    public function patientccdev(){

        return $this->belongsTo(PatientCcdev::class);

    }
}
