<?php

namespace App\Models\V1\PSGC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        $request = app('request');

        // Retrieve the parameter value from the route
        $parameterValue = $request->route()->parameter('barangay');
        //dd($parameterValue);
        // Check if the parameter value is a string and has a length of 10
        if (is_string($parameterValue) && strlen($parameterValue) === 10) {
            return 'psgc_10_digit_code';
        } else {
            // Default to 'slug' if the condition is not met
            return 'code';
        }
    }

    /**
     * City, Municipality, or SubMunicipality that this barangay belongs to.
     */
    public function geographic(): MorphTo
    {
        return $this->morphTo();
    }

    public function facility(): HasMany
    {
        return $this->hasMany(Facility::class);
    }
}
