<?php

namespace App\Models\V1\PSGC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Barangay extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'psgc_10_digit_code', 'geographic_type', 'geographic_id', 'name', 'urban_rural', 'population'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id', 'geographic_type', 'geographic_id'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    /**
     * City, Municipality, or SubMunicipality that this barangay belongs to.
     *
     * @return MorphTo
     */
    public function geographic(): MorphTo
    {
        return $this->morphTo();
    }
}
