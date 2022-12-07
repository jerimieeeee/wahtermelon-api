<?php

namespace App\Models\V1\Consultation;

use App\Models\V1\Libraries\LibComplaint;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultNotesComplaint extends Model
{
    use HasFactory, FilterByUser;
    protected $table='consult_notes_complaints';
    protected $primaryKey = 'id';

    protected $fillable = [
      'notes_id',
      'consult_id',
      'patient_id',
      'complaint_id',
      'complaint_date',
      'user_id',
      'facility_code',
    ];

    public function consultNotes(){
        return $this->belongsTo(ConsultNotes::class, 'notes_id', 'id');
    }

    public function libComplaints(): BelongsTo
    {
        return $this->belongsTo(LibComplaint::class, 'complaint_id', 'complaint_id');
    }

}
