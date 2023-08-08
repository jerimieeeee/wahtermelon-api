<?php

namespace App\Models\V1\Household;

use App\Models\User;
use App\Models\V1\FamilyPlanning\PatientFpChart;
use App\Models\V1\FamilyPlanning\PatientFpHistory;
use App\Models\V1\FamilyPlanning\PatientFpMethod;
use App\Models\V1\FamilyPlanning\PatientFpPelvicExam;
use App\Models\V1\FamilyPlanning\PatientFpPhysicalExam;
use App\Models\V1\Libraries\LibEnvironmentalResult;
use App\Models\V1\Libraries\LibEnvironmentalSewage;
use App\Models\V1\Libraries\LibEnvironmentalToiletFacility;
use App\Models\V1\Libraries\LibEnvironmentalWasteManagement;
use App\Models\V1\Libraries\LibEnvironmentalWaterType;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseholdEnvironmental extends Model
{
    use SoftDeletes, HasFactory, FilterByUser, HasUlids, FilterByFacility;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'validation_date' => 'date:Y-m-d',
        'arsenic_date' => 'date:Y-m-d',
    ];

    public function getRouteKeyName()
    {
        return 'household_folder_id';
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function householdFolder()
    {
        return $this->belongsTo(HouseholdFolder::class, 'household_folder_id', 'id');
    }

    public function waterTypes()
    {
        return $this->belongsTo(LibEnvironmentalWaterType::class, 'water_type_code', 'code');
    }

    public function toiletFacility()
    {
        return $this->belongsTo(LibEnvironmentalToiletFacility::class, 'toilet_facility_code', 'code');
    }

    public function sewage()
    {
        return $this->belongsTo(LibEnvironmentalSewage::class, 'sewage_code', 'code');
    }

    public function wasteManagement()
    {
        return $this->belongsTo(LibEnvironmentalWasteManagement::class, 'waste_management_code', 'code');
    }

}
