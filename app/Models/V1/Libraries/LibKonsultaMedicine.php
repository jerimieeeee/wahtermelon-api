<?php

namespace App\Models\V1\Libraries;

use App\Traits\HasSearchFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibKonsultaMedicine extends Model
{
    use HasFactory, HasSearchFilter;

    public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    protected $hidden = ['id'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    public function generic(): BelongsTo
    {
        return $this->belongsTo(LibKonsultaMedicineGeneric::class, 'generic_code', 'code');
    }

    public function salt(): BelongsTo
    {
        return $this->belongsTo(LibKonsultaMedicineSalt::class, 'salt_code', 'code');
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(LibKonsultaMedicineForm::class, 'form_code', 'code');
    }

    public function strength(): BelongsTo
    {
        return $this->belongsTo(LibKonsultaMedicineStrength::class, 'strength_code', 'code');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(LibKonsultaMedicineUnit::class, 'unit_code', 'code');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(LibKonsultaMedicinePackage::class, 'package_code', 'code');
    }
}
