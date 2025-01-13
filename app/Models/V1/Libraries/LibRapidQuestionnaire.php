<?php

namespace App\Models\V1\Libraries;

use App\Models\V1\Adolescent\ConsultAsrhRapidAnswer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibRapidQuestionnaire extends Model
{
    use HasFactory;
    public $primaryKey = 'id';
    protected $table = 'lib_rapid_questionnaires';
    public $timestamps = false;

    public function algorithm()
    {
        return $this->belongsToMany(
            LibAsrhAlgorithm::class,
            'lib_asrh_algorithm_pivot',
            'lib_rapid_questionnaire_id',
            'lib_asrh_algorithm_code'
        );
    }
}
