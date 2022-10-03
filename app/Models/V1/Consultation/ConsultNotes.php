<?php

namespace App\Models\V1\Consultation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultNotes extends Model
{
    protected $table='consult_notes';

    protected $primaryKey = 'id';
    protected $guarded = ['id',];
}
