<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasSearchFilter;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid, HasSearchFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthdate' => 'date:Y-m-d',
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

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

    public function suffixName(): BelongsTo
    {
        return $this->belongsTo(LibSuffixName::class, 'suffix_name', 'code');
    }

}
