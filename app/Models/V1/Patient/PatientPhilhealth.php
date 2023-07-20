<?php

namespace App\Models\V1\Patient;

use App\Models\User;
use App\Models\V1\Konsulta\KonsultaRegistrationList;
use App\Models\V1\Libraries\LibMemberRelationship;
use App\Models\V1\Libraries\LibPhilhealthEnlistmentStatus;
use App\Models\V1\Libraries\LibPhilhealthMembershipCategory;
use App\Models\V1\Libraries\LibPhilhealthMembershipType;
use App\Models\V1\Libraries\LibPhilhealthPackageType;
use App\Models\V1\Libraries\LibSuffixName;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use App\Traits\HasSearchFilter;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientPhilhealth extends Model
{
    use HasFactory, HasSearchFilter, FilterByUser;

    protected $table = 'patient_philhealth';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'enlistment_date' => 'date:Y-m-d',
        'member_birthdate' => 'date:Y-m-d',
        'effectivity_year' => 'date:Y'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setMemberLastNameAttribute($value)
    {
        $this->attributes['member_last_name'] = ucwords(strtolower($value));
    }

    public function setMemberFirstNameAttribute($value)
    {
        $this->attributes['member_first_name'] = ucwords(strtolower($value));
    }

    public function setMemberMiddleNameAttribute($value)
    {
        $this->attributes['member_middle_name'] = ucwords(strtolower($value));
    }

    public function setEmployerAddressAttribute($value)
    {
        $this->attributes['employer_address'] = ucwords(strtolower($value));
    }

    public function memberSuffixName(): BelongsTo
    {
        return $this->belongsTo(LibSuffixName::class, 'member_suffix_name', 'code');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function enlistmentStatus()
    {
        return $this->belongsTo(LibPhilhealthEnlistmentStatus::class, 'enlistment_status_id', 'id');
    }

    public function packageType()
    {
        return $this->belongsTo(LibPhilhealthPackageType::class, 'package_type_id', 'id');
    }

    public function membershipType()
    {
        return $this->belongsTo(LibPhilhealthMembershipType::class, 'membership_type_id', 'id');
    }

    public function membershipCategory()
    {
        return $this->belongsTo(LibPhilhealthMembershipCategory::class, 'membership_category_id', 'id');
    }

    public function memberRelation()
    {
        return $this->belongsTo(LibMemberRelationship::class, 'member_relation_id', 'id');
    }

    public function konsultaRegistration()
    {
        return $this->hasMany(KonsultaRegistrationList::class, 'philhealth_id', 'philhealth_id');
    }
}
