<?php

namespace App\Models\V1\Adolescent;

use App\Models\User;
use App\Models\V1\Libraries\LibAsrhAlgorithm;
use App\Models\V1\Libraries\LibRapidQuestionnaire;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByFacility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultAsrhRapidAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\V1\Adolescent\ConsultAsrhRapidAnswerFactory> */
    use HasFactory, HasUlids, FilterByUser, FilterByFacility, CascadeSoftDeletes;

    protected $guarded = [
        'id',
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

    public function consultRapid()
    {
        return $this->belongsTo(ConsultAsrhRapid::class);
    }

    public function question()
    {
        return $this->belongsTo(LibRapidQuestionnaire::class, 'lib_rapid_questionnaire_id', 'id');
    }
}
