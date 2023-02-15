<?php

namespace App\Models\V1\Patient;

use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PatientSocialHistory extends Model
{
    use HasFactory, HasUuids, FilterByUser;

    protected $table = 'patient_social_histories';

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

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

    public function libmedicalHistory()
    {
        return $this->belongsTo(LibMedicalHistory::class, 'medical_history_id', 'id');
    }

    public function libmedicalHistoryCategory()
    {
        return $this->belongsTo(LibMedicalHistoryCategory::class, 'category', 'id');
    }
}
