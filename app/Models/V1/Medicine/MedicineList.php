<?php

namespace App\Models\V1\Medicine;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibKonsultaMedicine;
use App\Models\V1\Libraries\LibMedicine;
use App\Models\V1\Libraries\LibMedicineDoseRegimen;
use App\Models\V1\Libraries\LibMedicineDurationFrequency;
use App\Models\V1\Libraries\LibMedicinePreparation;
use App\Models\V1\Libraries\LibMedicinePurpose;
use App\Models\V1\Libraries\LibMedicineRoute;
use App\Models\V1\Libraries\LibMedicineUnitOfMeasurement;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicineList extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, HasUlids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'dosage_quantity' => 'integer',
        'duration_intake' => 'integer',
        'quantity' => 'integer',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setAddedMedicineAttribute($value)
    {
        $this->attributes['added_medicine'] = ucwords(strtolower($value));
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function konsultaMedicine()
    {
        return $this->belongsTo(LibKonsultaMedicine::class, 'konsulta_medicine_code', 'code');
    }

    public function medicine()
    {
        return $this->belongsTo(LibMedicine::class, 'medicine_code', 'hprodid');
    }

    public function dosageUom()
    {
        return $this->belongsTo(LibMedicineUnitOfMeasurement::class, 'dosage_uom');
    }

    public function doseRegimen()
    {
        return $this->belongsTo(LibMedicineDoseRegimen::class, 'dose_regimen');
    }

    public function medicinePurpose()
    {
        return $this->belongsTo(LibMedicinePurpose::class, 'medicine_purpose');
    }

    public function durationFrequency()
    {
        return $this->belongsTo(LibMedicineDurationFrequency::class, 'duration_frequency');
    }

    public function quantityPreparation()
    {
        return $this->belongsTo(LibMedicinePreparation::class, 'quantity_preparation');
    }

    public function dispensing()
    {
        return $this->hasMany(MedicineDispensing::class, 'prescription_id', 'id');
    }

    public function medicineRoute()
    {
        return $this->belongsTo(LibMedicineRoute::class, 'medicine_route_code', 'code');
    }
}
