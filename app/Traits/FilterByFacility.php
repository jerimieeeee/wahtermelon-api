<?php

namespace App\Traits;

use App\Models\V1\Household\HouseholdMember;
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
        if (auth()->check() && ! request()->disable_filter) {
            static::addGlobalScope('facility', function (Builder $builder) {
                // Disable the scope if querying through the hasOneThrough relationship
                if ($builder->getQuery()->joins && count($builder->getQuery()->joins) === 1) {
                    $join = $builder->getQuery()->joins[0];
                    if ($join->table === (new HouseholdMember)->getTable() && $join->type === 'inner') {
                        return;
                    }
                }

                if (Schema::hasColumn($builder->getQuery()->from, 'facility_code') && isset(auth()->user()->facility_code)) {
                    $builder->where($builder->getQuery()->from.'.facility_code', auth()->user()->facility_code);
                }
            });
        }
    }
}
