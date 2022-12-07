<?php

namespace App\Models\V1\Consultation;

use App\Models\V1\Libraries\LibDiagnosis;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultNotesInitialDx extends Model
{
    use HasFactory, FilterByUser;

    protected $table='consult_notes_initial_dxes';
    protected $primaryKey = 'id';

    protected $fillable = [
      'notes_id',
      'user_id',
      'facility_code',
      'class_id',
      'idx_remark',
    ];

    public function diagnosis(): BelongsTo
    {
        return $this->belongsTo(LibDiagnosis::class, 'class_id', 'class_id');
    }

    public function consultNotes(){
        return $this->hasMany(ConsultNotes::class);
    }

}
