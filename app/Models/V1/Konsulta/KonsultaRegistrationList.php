<?php

namespace App\Models\V1\Konsulta;

use App\Models\User;
use App\Models\V1\Libraries\LibPhilhealthEnlistmentStatus;
use App\Models\V1\Libraries\LibPhilhealthMembershipType;
use App\Models\V1\Libraries\LibPhilhealthPackageType;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use App\Traits\HasSearchFilter;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultaRegistrationList extends Model
{
    use HasFactory, HasUuids, FilterByUser, FilterByFacility, HasSearchFilter;

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'assigned_date' => 'date:Y-m-d',
        'birthdate' => 'date:Y-m-d',
        'member_birthdate' => 'date:Y-m-d',
    ];

    protected function serializeDate(DateTimeInterface $date)
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

    public function assignedStatus()
    {
        return $this->belongsTo(LibPhilhealthEnlistmentStatus::class, 'assigned_status_id', 'id');
    }

    public function packageType()
    {
        return $this->belongsTo(LibPhilhealthPackageType::class, 'package_type_id', 'id');
    }

    public function membershipType()
    {
        return $this->belongsTo(LibPhilhealthMembershipType::class, 'membership_type_id', 'id');
    }
}
