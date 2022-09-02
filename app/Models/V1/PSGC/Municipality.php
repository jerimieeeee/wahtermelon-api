<?php

namespace App\Models\V1\PSGC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Municipality extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'psgc_10_digit_code', 'geographic_type', 'geographic_id', 'name', 'geo_level', 'income_class', 'population'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id', 'geographic_id'];

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
     * Collection of barangays under this municipality.
     */
    public function barangays(): MorphMany
    {
        return $this->morphMany(Barangay::class, 'geographic');
    }

    /**
     * Province or District that this municipality belongs to.
     *
     * @return MorphTo
     */
    public function geographic(): MorphTo
    {
        return $this->morphTo();
    }
}
