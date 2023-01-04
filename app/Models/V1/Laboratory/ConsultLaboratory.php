<?php

namespace App\Models\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibLaboratory;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultLaboratory extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, HasUuids, FilterByUser;

    protected $guarded = [
        'id'
    ];

    protected $cascadeDeletes = ['cbc', 'creatinine', 'chestXray', 'ecg'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'request_date' => 'date:Y-m-d',
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

    public function laboratory()
    {
        return $this->belongsTo(LibLaboratory::class, 'lab_code', 'code');
    }

    public function cbc()
    {
        return $this->hasOne(ConsultLaboratoryCbc::class, 'request_id', 'id');
    }

    public function creatinine()
    {
        return $this->hasOne(ConsultLaboratoryCreatinine::class, 'request_id', 'id');
    }

    public function chestXray()
    {
        return $this->hasOne(ConsultLaboratoryChestXray::class, 'request_id', 'id');
    }

    public function ecg()
    {
        return $this->hasOne(ConsultLaboratoryEcg::class, 'request_id', 'id');
    }
}
