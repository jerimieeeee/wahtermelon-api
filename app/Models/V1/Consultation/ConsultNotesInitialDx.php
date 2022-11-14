<?php

namespace App\Models\V1\Consultation;

use App\Models\V1\Libraries\LibDiagnosis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultNotesInitialDx extends Model
{
    use HasFactory;

    protected $table='consult_notes_initial_dxes';
    protected $primaryKey = 'id';

    protected $fillable = [
      'notes_id',
      'user_id',
      'class_id',
      'idx_remark',
    ];

    public function Diagnosis(): BelongsTo
    {
        return $this->belongsTo(LibDiagnosis::class, 'class_id', 'code');
    }

    public function Consult_notes(): BelongsTo
    {
        return $this->belongsTo(ConsultNotes::class, 'notes_id', 'code');
    }
}
