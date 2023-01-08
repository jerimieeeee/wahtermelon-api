<?php

namespace App\Models\V1\Laboratory;

use App\Models\V1\Libraries\LibLaboratoryBloodInStool;
use App\Models\V1\Libraries\LibLaboratoryStoolColor;
use App\Models\V1\Libraries\LibLaboratoryStoolConsistency;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultLaboratoryFecalysis extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, HasUuids, FilterByUser;

    protected $table = 'consult_laboratory_fecalysis';

    protected $guarded = [
        'id'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'laboratory_date' => 'date:Y-m-d',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function consult()
    {
        return $this->belongsTo(Consult::class);
    }

    public function laboratoryRequest()
    {
        return $this->belongsTo(ConsultLaboratory::class, 'request_id', 'id');
    }

    public function laboratoryStatus()
    {
        return $this->belongsTo(LibLaboratoryStatus::class, 'lab_status_code', 'code');
    }

    public function color()
    {
        return $this->belongsTo(LibLaboratoryStoolColor::class, 'color_code', 'code');
    }

    public function consistency()
    {
        return $this->belongsTo(LibLaboratoryStoolConsistency::class, 'consistency_code', 'code');
    }

    public function blood()
    {
        return $this->belongsTo(LibLaboratoryBloodInStool::class, 'blood_code', 'code');
    }
}
