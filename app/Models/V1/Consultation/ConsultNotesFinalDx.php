<?php

namespace App\Models\V1\Consultation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultNotesFinalDx extends Model
{
    protected $table='consult_notes_final_dxes';

    protected $fillable = [
      'notes_id',
      'user_id',
      'icd10_code',
      'dx_remarks',
    ];
}
