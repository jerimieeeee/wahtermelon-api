<?php

namespace App\Models\V1\PSGC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SubMunicipality extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'psgc_10_digit_code', 'city_id', 'name', 'population'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id', 'city_id'];

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
     * Collection of barangays under this sub municipality.
     */
    public function barangays(): MorphMany
    {
        return $this->morphMany(Barangay::class, 'geographic');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
