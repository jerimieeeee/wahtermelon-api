<?php

namespace App\Models\V1\Patient;

use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory, HasUuid;

    protected $guarded = [
        'id', 'facility_id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'birthdate' => 'date:Y-m-d',
        'indegenous_flag' => 'boolean',
        'consent_flag' => 'boolean',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes["last_name"] = ucwords(strtolower($value));
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes["first_name"] = ucwords(strtolower($value));
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes["middle_name"] = ucwords(strtolower($value));
    }

    public function setMothersNameAttribute($value)
    {
        $this->attributes["mothers_name"] = ucwords(strtolower($value));
    }

}
