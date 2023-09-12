<?php

namespace App\Models\V1\Household;

use App\Models\User;
use App\Models\V1\Libraries\LibResidenceClassification;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseholdFolder extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, HasUuid, FilterByUser; //FilterByFacility;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'cct_date' => 'date:Y-m-d',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucwords(strtolower($value));
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function householdMember()
    {
        return $this->hasMany(HouseholdMember::class);
    }

    public function residenceClassification()
    {
        return $this->belongsTo(LibResidenceClassification::class, 'residence_classification_code', 'code');
    }

    public function environmentalLatest()
    {
        return $this->hasOne(HouseholdEnvironmental::class, 'household_folder_id', 'id')
                ->latest('effectivity_year');
    }
}
