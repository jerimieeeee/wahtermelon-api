<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibEducation extends Model
{
    use HasFactory;

    public $primaryKey = 'education_id';
    public $timestamps = false;

}
