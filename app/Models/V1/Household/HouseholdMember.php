<?php

namespace App\Models\V1\Household;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseholdMember extends Model
{
    use HasFactory, SoftDeletes, FilterByUser;

    protected $fillable = ['household_folder_id', 'patient_id', 'user_id', 'family_role_code'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function household()
    {
        return $this->belongsTo(HouseholdFolder::class);
    }
}
