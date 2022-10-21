<?php

namespace App\Models\V1\Childcare;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultCcdevBreastfed extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id',];

    //protected $dates = ['deleted_at'];

    protected $casts = [
        'ebf_date' => 'date:Y-m-d',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
