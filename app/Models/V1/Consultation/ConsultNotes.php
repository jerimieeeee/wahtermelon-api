<?php

namespace App\Models\V1\Consultation;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultNotes extends Model
{
    use HasFactory, FilterByUser;

    protected $table='consult_notes';

    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // public function notes_complaint(){
    //     return $this->hasMany(ConsultNotesComplaint::class);
    // }


}
