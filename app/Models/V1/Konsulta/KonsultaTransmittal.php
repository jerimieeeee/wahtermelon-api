<?php

namespace App\Models\V1\Konsulta;

use App\Traits\FilterByUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultaTransmittal extends Model
{
    use HasFactory, HasUuids, FilterByUser;

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'xml_errors' => 'array',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
