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

    protected $table='consult_notes_final_dxes';
    protected $primaryKey = 'id';

    protected $fillable = [
      'notes_id',
      'user_id',
      'icd10_code',
      'fdx_remark',
    ];

    public function Icd10(): BelongsTo
    {
        return $this->belongsTo(LibIcd10::class, 'icd10_code', 'code');
    }
}
