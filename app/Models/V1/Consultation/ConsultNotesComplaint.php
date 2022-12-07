<?php

namespace App\Models\V1\Consultation;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function consult_notes(){
        return $this->hasMany(ConsultNotes::class);
    }

}
