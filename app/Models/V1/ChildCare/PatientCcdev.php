<?php

namespace App\Models\V1\Childcare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientCcdev extends Model
{
    use SoftDeletes;

    protected $guarded = ['id',];


    public function consultccdevservice(){

        return $this->hasOne(PatientCcdev::class);

    }

    public function consultccdev(){

        return $this->hasOne(PatientCcdev::class);

    }
}
