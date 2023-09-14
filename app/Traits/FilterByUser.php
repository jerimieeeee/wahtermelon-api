<?php

namespace App\Traits;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait FilterByUser
{
    protected static function boot()
    {

        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'facility_code')) {
                if (isset(auth()->user()->facility_code)) {
                    $model->facility_code = auth()->user()->facility_code;
                }
            }
            if (Schema::hasColumn($model->getTable(), 'transaction_number')) {
                if(auth()->user()) {
                    if (auth()->user()->konsultaCredential && !isset($model->transaction_number)) {
                        if ($model->getTable() != 'consults' || ($model->getTable() == 'consults' && request()->pt_group == 'cn' && request()->is_konsulta == 1)) {
                            $prefix = auth()->user()->konsultaCredential->accreditation_number . date('Ym');
                            $transactionNumber = IdGenerator::generate(['table' => $model->getTable(), 'field' => 'transaction_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
                            $model->transaction_number = $transactionNumber;
                        }
                    }
                }
            }
            if (Schema::hasColumn($model->getTable(), 'case_number')) {
                if (!isset($model->case_number)) {
                    if ($model->getTable() === 'patient_gbv_intakes') {
                        $dohShortCode = substr(auth()->user()->facility_code, -6);
                        $prefix = $dohShortCode . date('Ym');
                        $caseNumber = IdGenerator::generate(['table' => $model->getTable(), 'field' => 'case_number', 'length' => 16, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
                        $model->case_number = $caseNumber;
                    } else {
                        if (isset(auth()->user()->konsultaCredential)) {
                            $prefix = 'T' . auth()->user()->konsultaCredential->accreditation_number . date('Ym');
                            $caseNumber = IdGenerator::generate(['table' => $model->getTable(), 'field' => 'case_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
                            $model->case_number = $caseNumber;
                        }
                    }
                }
            }
            if(auth()->user()) {
                $model->user_id = auth()->id();
            }
        });

        self::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'transaction_number')) {
                if(auth()->user()) {
                    if (auth()->user()->konsultaCredential && !isset($model->transaction_number)) {
                        if ($model->getTable() != 'consults' || ($model->getTable() == 'consults' && request()->pt_group == 'cn' && request()->is_konsulta == 1)) {
                            $prefix = auth()->user()->konsultaCredential->accreditation_number . date('Ym');
                            $transactionNumber = IdGenerator::generate(['table' => $model->getTable(), 'field' => 'transaction_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
                            $model->transaction_number = $transactionNumber;
                        }
                        if($model->getTable() == 'consults' && request()->pt_group == 'cn' && request()->is_konsulta == 0) {
                            $model->transaction_number = null;
                        }
                    }
                }
            }
        });


        /* self::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'facility_code')) {
                $model->facility_code = auth()->user()->facility_code;
            }
            if (Schema::hasColumn($model->getTable(), 'transaction_number')) {
                if (auth()->user()->konsultaCredential && ! isset($model->transaction_number)) {
                    if ($model->getTable() != 'consults' || ($model->getTable() == 'consults' && request()->pt_group == 'cn')) {
                        $prefix = auth()->user()->konsultaCredential->accreditation_number.date('Ym');
                        $transactionNumber = IdGenerator::generate(['table' => $model->getTable(), 'field' => 'transaction_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
                        $model->transaction_number = $transactionNumber;
                    }
                }
            }
            if (Schema::hasColumn($model->getTable(), 'case_number')) {
                if (auth()->user()->konsultaCredential && ! isset($model->case_number)) {
                    $prefix = 'T'.auth()->user()->konsultaCredential->accreditation_number.date('Ym');
                    $caseNumber = IdGenerator::generate(['table' => $model->getTable(), 'field' => 'case_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
                    $model->case_number = $caseNumber;
                }
            }
            $model->user_id = auth()->id();
        }); */

        /*self::addGlobalScope(function(Builder $builder) {
            $builder->where('facility_code', auth()->user()->facility_code);
        });*/
    }
}
