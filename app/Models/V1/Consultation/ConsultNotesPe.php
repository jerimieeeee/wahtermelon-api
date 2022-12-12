<?php

namespace App\Models\V1\Consultation;

use App\Models\V1\Libraries\LibPe;
use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultNotesPe extends Model
{
    use HasFactory, HasUuid, FilterByUser;

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function physicalExam(): BelongsTo
    {
        return $this->belongsTo(LibPe::class, 'pe_id', 'pe_id');
    }

    public function consultNotes(){
        return $this->hasMany(ConsultNotes::class);
    }

}
