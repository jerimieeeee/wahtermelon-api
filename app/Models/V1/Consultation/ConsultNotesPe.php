<?php

namespace App\Models\V1\Consultation;

use App\Models\V1\Libraries\LibPe;
use App\Traits\FilterByUser;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultNotesPe extends Model
{
    use HasFactory, HasUuids, FilterByUser;

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $keyType = 'string';

    public function consultNotes()
    {
        return $this->hasMany(ConsultNotes::class);
    }

    public function libPhysicalExam(): BelongsTo
    {
        return $this->belongsTo(LibPe::class, 'pe_id', 'pe_id');
    }
}
