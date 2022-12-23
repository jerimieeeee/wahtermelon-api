<?php
namespace  App\Traits;
use Haruncpi\LaravelIdGenerator\IdGenerator;
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
            if(Schema::hasColumn($model->getTable(), 'transaction_number')) {
                $initial = 'E';

                $prefix = $initial . auth()->user()->konsultaCredential->accreditation_number . date('Ym');
                $transactionNumber = IdGenerator::generate(['table' => $model->getTable(), 'field' => 'transaction_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
                $model->transaction_number = $transactionNumber;
            }
            $model->user_id = auth()->id();
        });

        /*self::addGlobalScope(function(Builder $builder) {
            $builder->where('facility_code', auth()->user()->facility_code);
        });*/
    }

}
