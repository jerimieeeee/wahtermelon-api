<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

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
                if(Schema::hasColumn($builder->getQuery()->from, 'facility_code') && isset(auth()->user()->facility_code)){
                    $builder->where('facility_code', auth()->user()->facility_code);
                }
            });
        }
    }
}
