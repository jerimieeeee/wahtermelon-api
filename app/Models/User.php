<?php

namespace App\Models;

use App\Models\V1\Libraries\LibDesignation;
use App\Models\V1\Libraries\LibEmployer;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Models\V1\PSGC\Facility;
use App\Traits\HasSearchFilter;
use App\Traits\HasUuid;
use DateTimeInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid, HasSearchFilter, HasRolesAndAbilities;

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
        'last_seen_at' => 'datetime',
        'attendant_cc_flag' => 'boolean',
        'attendant_mc_flag' => 'boolean',
        'attendant_tb_flag' => 'boolean',
        'attendant_ab_flag' => 'boolean',
        'attendant_ml_flag' => 'boolean',
        'attendant_fp_flag' => 'boolean',
        'attendant_cv_flag' => 'boolean',
        'aja_flag' => 'boolean',
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
        $this->attributes['last_name'] = ucwords(strtolower($value));
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords(strtolower($value));
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = ucwords(strtolower($value));
    }

    public function suffixName(): BelongsTo
    {
        return $this->belongsTo(LibSuffixName::class, 'suffix_name', 'code');
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(LibDesignation::class, 'designation_code', 'code');
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(LibEmployer::class, 'employer_code', 'code');
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function philhealthCredential()
    {
        return $this->hasMany(PhilhealthCredential::class, 'facility_code', 'facility_code');
    }

    public function konsultaCredential()
    {
        return $this->hasOne(PhilhealthCredential::class, 'facility_code', 'facility_code')
            ->whereProgramCode('kp');
    }

    public function eclaimsCredential($program_code)
    {
        return $this->hasOne(PhilhealthCredential::class, 'facility_code', 'facility_code')
            ->whereProgramCode($program_code);
    }

    public function patient()
    {
        return $this->hasMany(Patient::class);
    }

    public function getUserAbilities()
    {
        $abilities = $this->getAbilities()->merge($this->getForbiddenAbilities());

        $abilities->each(function ($ability) {
            $ability->forbidden = $this->getForbiddenAbilities()->contains($ability);
        });

        return $abilities;
    }
}
