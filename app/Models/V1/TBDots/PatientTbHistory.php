<?php

namespace App\Models\V1\TBDots;

use App\Models\V1\Libraries\LibTbTreatmentOutcome;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTbHistory extends Model
{
    use HasFactory, HasUlids, FilterByUser;

    // protected $table = 'patient_tb_histories';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function outcome()
    {
        return $this->belongsTo(LibTbTreatmentOutcome::class, 'outcome_code', 'code');
    }
}
