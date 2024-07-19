<?php

namespace App\Models\V1\Consultation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ConsultFeedback extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'consult_feedback';

    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
    ];
}
