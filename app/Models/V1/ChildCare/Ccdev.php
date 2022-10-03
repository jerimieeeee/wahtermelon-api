<?php

namespace App\Models\V1\Childcare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ccdev extends Model
{
    protected $primaryKey = 'id';

    protected $guarded = ['id',];
    use SoftDeletes;


    public function consultccdevservice(){

        return $this->hasOne(Ccdev::class);

    }

    public function consultccdev(){

        return $this->hasOne(Ccdev::class);

    }
}
