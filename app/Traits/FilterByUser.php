<?php
namespace  App\Traits;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait FilterByUser
{
    protected static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            if(Schema::hasColumn($model->getTable(), 'facility_code')) {
                $model->facility_code = auth()->user()->facility_code;
            }
            $model->user_id = auth()->id();
        });

        /*self::addGlobalScope(function(Builder $builder) {
            $builder->where('facility_code', auth()->user()->facility_code);
        });*/
    }

}
