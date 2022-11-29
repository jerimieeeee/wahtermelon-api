<?php

namespace App\Models\V1\Consultation;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultNotesPe extends Model
{
    use HasFactory, FilterByUser;

    protected $primaryKey = 'id';
    protected $guarded = ['id',];



}
