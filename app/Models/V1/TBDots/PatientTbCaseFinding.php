<?php

namespace App\Models\V1\TBDots;

use App\Models\V1\Libraries\LibTbPatientSource;
use App\Models\V1\Libraries\LibTbPreviousTbTreatment;
use App\Models\V1\Libraries\LibTbRegGroup;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTbCaseFinding extends Model
{
    use HasFactory, HasUlids, FilterByUser;

    protected $guarded = [
        'id'
    ];

    protected $keyType = 'string';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function source()
    {
        return $this->belongsTo(LibTbPatientSource::class, 'source_code', 'code');
    }

    public function reg_group()
    {
        return $this->belongsTo(LibTbRegGroup::class, 'reg_group_code', 'code');
    }

    public function previous_tb_treatment()
    {
        return $this->belongsTo(LibTbPreviousTbTreatment::class, 'previous_tb_treatment_code', 'code');
    }
}
