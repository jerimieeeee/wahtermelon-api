<?php

namespace App\Models\V1\Childcare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultCcdevBreastfeds extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id',];
}
