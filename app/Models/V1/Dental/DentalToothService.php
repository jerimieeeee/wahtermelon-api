<?php

namespace App\Models\V1\Dental;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V1\Libraries\LibDentalToothService;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class DentalToothService extends Model
{
    use HasFactory, FilterByUser, FilterByFacility, HasUlids;

    protected $table = 'dental_tooth_services';

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

    public function toothService()
    {
        return $this->belongsTo(LibDentalToothService::class, 'service_code', 'code');
    }

    public function consult()
    {
        return $this->belongsTo(Consult::class, 'consult_id', 'id');
    }
}
