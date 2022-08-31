<?php

namespace App\Models\V1\PSGC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code', 'psgc_10_digit_code', 'region_id', 'name', 'population'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['id', 'region_id'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    public function cities(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(City::class, 'geographic');
    }

    public function municipalities(): MorphToMany
    {
        return $this->morphMany(Municipality::class, 'geographic');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
