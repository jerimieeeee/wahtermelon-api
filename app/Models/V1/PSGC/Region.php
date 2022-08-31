<?php

namespace App\Models\V1\PSGC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'psgc_10_digit_code', 'name', 'population'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
