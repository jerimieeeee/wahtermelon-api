<?php

namespace App\Models\V1\Dental;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\V1\Libraries\LibDentalToothCondition;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class DentalToothCondition extends Model
{
    use HasFactory, FilterByUser, FilterByFacility, HasUlids;

    protected $table = 'dental_tooth_conditions';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    public $incrementing = false;

    protected $keyType = 'string';

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    /* public function toothCondition()
    {
        return $this->belongsTo(LibDentalToothCondition::class, 'service_code', 'code');
    } */
}
