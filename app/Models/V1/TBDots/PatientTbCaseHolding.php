<?php

namespace App\Models\V1\TBDots;

use App\Models\V1\Libraries\LibTbAnatomicalSite;
use App\Models\V1\Libraries\LibTbBacteriologicalStatus;
use App\Models\V1\Libraries\LibTbEnrollAs;
use App\Models\V1\Libraries\LibTbEptbSite;
use App\Models\V1\Libraries\LibTbIptType;
use App\Models\V1\Libraries\LibTbTreatmentRegimen;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTbCaseHolding extends Model
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

    public function enrollAs()
    {
        return $this->belongsTo(LibTbEnrollAs::class, 'enroll_as_code', 'code');
    }

    public function treatmentRegimen()
    {
        return $this->belongsTo(LibTbTreatmentRegimen::class, 'treatment_regiment_code', 'code');
    }

    public function bacteriologicalStatus()
    {
        return $this->belongsTo(LibTbBacteriologicalStatus::class, 'bateriological_status_code', 'code');
    }

    public function anatomicalSite()
    {
        return $this->belongsTo(LibTbAnatomicalSite::class, 'anatomical_site_code', 'code');
    }

    public function iptType()
    {
        return $this->belongsTo(LibTbIptType::class, 'ipt_type_code', 'code');
    }

    public function eptbSite()
    {
        return $this->belongsTo(LibTbEptbSite::class, 'eptb_site_id', 'id');
    }
}
