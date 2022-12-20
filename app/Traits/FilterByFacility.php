<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByFacility
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        if (auth()->check()) {
            static::addGlobalScope('facility', function (Builder $builder) {
                $builder->where('facility_code', auth()->user()->facility_code);
            });
        }
    }
}
