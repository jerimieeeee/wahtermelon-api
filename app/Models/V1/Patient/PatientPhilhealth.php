<?php

namespace App\Models\V1\Patient;

use App\Models\V1\Libraries\LibSuffixName;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientPhilhealth extends Model
{
    use HasFactory;

    public $primaryKey = 'patient_philhealth';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'enlistment_date' => 'date:Y-m-d',
        'effectivity_year' => 'date:Y'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setMemberLastNameAttribute($value)
    {
        $this->attributes["member_last_name"] = ucwords(strtolower($value));
    }

    public function setMemberFirstNameAttribute($value)
    {
        $this->attributes["member_first_name"] = ucwords(strtolower($value));
    }

    public function setMemberMiddleNameAttribute($value)
    {
        $this->attributes["member_middle_name"] = ucwords(strtolower($value));
    }

    public function setEmployerAddressAttribute($value)
    {
        $this->attributes["employer_address"] = ucwords(strtolower($value));
    }

    public function memberSuffixName(): BelongsTo
    {
        return $this->belongsTo(LibSuffixName::class, 'member_suffix_name', 'code');
    }
}
