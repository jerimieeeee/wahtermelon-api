<?php

namespace App\Models\V1\Household;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdMember extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected $hidden = ['pivot'];


}
