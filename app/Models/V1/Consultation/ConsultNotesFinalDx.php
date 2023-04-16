<?php

namespace App\Models\V1\Consultation;

use App\Models\V1\Libraries\LibIcd10;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultNotesFinalDx extends Model
{
    use HasFactory, FilterByUser;

    protected $table = 'consult_notes_final_dxes';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
    ];

    public function consultNotes()
    {
        return $this->belongsTo(ConsultNotes::class, 'notes_id', 'id');
    }

    public function libIcd10(): BelongsTo
    {
        return $this->belongsTo(LibIcd10::class, 'icd10_code', 'icd10_code');
    }
}
