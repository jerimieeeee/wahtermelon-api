<?php

namespace App\Models\V1\PSGC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facility extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facility_code',
        'short_code',
        'facility_name',
        'old_facility_name_1',
        'old_facility_name_2',
        'old_facility_name_3',
        'facility_major_type',
        'health_facility_type',
        'ownership_classification',
        'ownership_sub_classification',
        'service_capability',
        'bed_capacity',
        'region_id',
        'province_id',
        'municipality_id',
        'barangay_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id', 'region_id', 'province_id', 'municipality_id', 'barangay_id'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'facility_code';
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }
}
