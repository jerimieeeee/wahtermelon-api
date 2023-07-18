<?php

namespace App\Models\V1\Patient;

use App\Models\V1\Libraries\LibWashingtonDisabilityAnswer;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientWashingtonQuestion extends Model
{
    use HasFactory, HasUlids, FilterByUser;

    protected $guarded = [
        'id',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function difficultySeeingAns()
    {
        return $this->belongsTo(LibWashingtonDisabilityAnswer::class.'difficulty_seeing', 'id');
    }

    public function difficultyHearingAns()
    {
        return $this->belongsTo(LibWashingtonDisabilityAnswer::class.'difficulty_hearing', 'id');
    }

    public function difficultyWalkingAns()
    {
        return $this->belongsTo(LibWashingtonDisabilityAnswer::class.'difficulty_walking', 'id');
    }

    public function difficultyRememberingAns()
    {
        return $this->belongsTo(LibWashingtonDisabilityAnswer::class.'difficulty_remembering', 'id');
    }

    public function difficultySelfCareAns()
    {
        return $this->belongsTo(LibWashingtonDisabilityAnswer::class.'difficulty_self_care', 'id');
    }

    public function difficultySpeakingAns()
    {
        return $this->belongsTo(LibWashingtonDisabilityAnswer::class.'difficulty_speaking', 'id');
    }
}
