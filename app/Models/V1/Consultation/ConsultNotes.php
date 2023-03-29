<?php

namespace App\Models\V1\Consultation;

use App\Models\V1\Libraries\LibGeneralSurvey;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultNotes extends Model
{
    use HasFactory, FilterByUser;

    protected $table = 'consult_notes';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
    ];

    public function complaints()
    {
        return $this->hasMany(ConsultNotesComplaint::class, 'notes_id', 'id');
    }

    public function initialdx()
    {
        return $this->hasMany(ConsultNotesInitialDx::class, 'notes_id', 'id');
    }

    public function finaldx()
    {
        return $this->hasMany(ConsultNotesFinalDx::class, 'notes_id', 'id');
    }

    public function physicalExam()
    {
        return $this->hasMany(ConsultNotesPe::class, 'notes_id', 'id');
    }

    public function physicalExamRemarks()
    {
        return $this->hasOne(ConsultPeRemarks::class, 'notes_id', 'id');
    }

    public function consult()
    {
        return $this->belongsTo(Consult::class, 'consult_id', 'id');
    }

    public function management()
    {
        return $this->hasMany(ConsultNotesManagement::class, 'notes_id', 'id');
    }

    public function libGeneralSurvey()
    {
        return $this->belongsTo(LibGeneralSurvey::class, 'general_survey_code', 'code');
    }
}
