<?php

namespace App\Models\V1\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibComplaint extends Model
{
    use HasFactory;

    protected $primaryKey = 'complaint_id';
    public $incrementing = 'false';
    public $keyType = 'string';
}
