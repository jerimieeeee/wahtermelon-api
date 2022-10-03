<?php

namespace App\Models\V1\Consultation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultNotesInitialDx extends Model
{
    protected $table='consult_notes_initial_dxes';

    protected $fillable = [
      'notes_id',
      'user_id',
      'class_id',
      'dx_remarks',
    ];
}
