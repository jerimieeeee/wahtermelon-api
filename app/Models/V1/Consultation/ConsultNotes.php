<?php

namespace App\Models\V1\Consultation;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultNotes extends Model
{
    use HasFactory, FilterByUser;

    protected $table='consult_notes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'consult_id',
        'patient_id',
        'user_id',
        'facility_code',
        'complaint',
        'history',
        'physical_exam',
        'idx_remarks',
        'fdx_remarks',
        'plan',
      ];

    public function complaints(){
        return $this->hasMany(ConsultNotesComplaint::class, 'notes_id', 'id');
    }

    public function initialdx(){
        return $this->hasMany(ConsultNotesInitialDx::class, 'notes_id', 'id');
    }

    public function finaldx(){
        return $this->hasMany(ConsultNotesFinalDx::class, 'notes_id', 'id');
    }

    public function consultNotes()
    {
        return $this->belongsTo(Consult::class, 'consult_id', 'id');
    }


}
