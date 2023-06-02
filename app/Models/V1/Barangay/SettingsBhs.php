<?php

namespace App\Models\V1\Barangay;

use App\Models\User;
use App\Models\V1\PSGC\Barangay;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SettingsBhs extends Model
{
    use HasFactory, HasUlids, FilterByUser, FilterByFacility;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setBhsNameAttribute($value)
    {
        $this->attributes['bhs_name'] = ucwords(strtolower($value));
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'code');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id', 'id');
    }

    public function bhsBarangay()
    {
        return $this->belongsToMany(SettingsCatchmentBarangay::class, 'settings_barangay_bhs');
    }
}
