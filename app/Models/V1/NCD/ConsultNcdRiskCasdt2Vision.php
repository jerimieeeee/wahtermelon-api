<?php

namespace App\Models\V1\NCD;

use App\Models\User;
use App\Models\V1\Libraries\LibNcdEyeComplaint;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class ConsultNcdRiskCasdt2Vision extends Model
{
    use HasFactory, HasUlids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function casdt2()
    {
        return $this->belongsTo(ConsultNcdRiskCasdt2::class, 'casdt2_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function eyeComplaint()
    {
        return $this->belongsTo(LibNcdEyeComplaint::class, 'eye_complaint', 'code');
    }
}
