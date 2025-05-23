<?php

namespace App\Models\V1\Laboratory;

use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Libraries\LibLaboratory;
use App\Models\V1\Libraries\LibLaboratoryRecommendation;
use App\Models\V1\Libraries\LibLaboratoryRequestStatus;
use App\Models\V1\Patient\Patient;
use App\Models\V1\PSGC\Facility;
use App\Traits\FilterByUser;
use DateTimeInterface;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FilterByFacility;

class ConsultLaboratory extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, HasUuids, FilterByUser, FilterByFacility;

    protected $guarded = [
        'id',
    ];

    protected $cascadeDeletes = [
        'cbc',
        'creatinine',
        'chestXray',
        'ecg',
        'fbs',
        'rbs',
        'hba1c',
        'papsmear',
        'ppd',
        'sputum',
        'fecalysis',
        'lipiProfile',
        'urinalysis',
        'oralGlucose',
        'fecalOccult',
        'gramStain',
        'microscopy',
        'ultrasound',
        'geneXpert',
        'dengueRdt',
        'serology',
        'biopsy',
        'malariaRdt',
        'skinSlit',
        'bloodchem',
        'potassium',
        'wetSmear',
        'hematology',
        'syphilis',
        'cervical',
        'xray',
    ];

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

    public function recommendation()
    {
        return $this->belongsTo(LibLaboratoryRecommendation::class, 'recommendation_code', 'code');
    }

    public function requestStatus()
    {
        return $this->belongsTo(LibLaboratoryRequestStatus::class, 'request_status_code', 'code');
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

    public function fbs()
    {
        return $this->hasOne(ConsultLaboratoryFbs::class, 'request_id', 'id');
    }

    public function rbs()
    {
        return $this->hasOne(ConsultLaboratoryRbs::class, 'request_id', 'id');
    }

    public function hba1c()
    {
        return $this->hasOne(ConsultLaboratoryHba1c::class, 'request_id', 'id');
    }

    public function papsmear()
    {
        return $this->hasOne(ConsultLaboratoryPapsmear::class, 'request_id', 'id');
    }

    public function ppd()
    {
        return $this->hasOne(ConsultLaboratoryPpd::class, 'request_id', 'id');
    }

    public function sputum()
    {
        return $this->hasOne(ConsultLaboratorySputum::class, 'request_id', 'id');
    }

    public function fecalysis()
    {
        return $this->hasOne(ConsultLaboratoryFecalysis::class, 'request_id', 'id');
    }

    public function lipiProfile()
    {
        return $this->hasOne(ConsultLaboratoryLipidProfile::class, 'request_id', 'id');
    }

    public function urinalysis()
    {
        return $this->hasOne(ConsultLaboratoryUrinalysis::class, 'request_id', 'id');
    }

    public function oralGlucose()
    {
        return $this->hasOne(ConsultLaboratoryOralGlucose::class, 'request_id', 'id');
    }

    public function fecalOccult()
    {
        return $this->hasOne(ConsultLaboratoryFecalOccult::class, 'request_id', 'id');
    }

    public function gramStain()
    {
        return $this->hasOne(ConsultLaboratoryGramStain::class, 'request_id', 'id');
    }

    public function microscopy()
    {
        return $this->hasOne(ConsultLaboratoryMicroscopy::class, 'request_id', 'id');
    }

    public function ultrasound()
    {
        return $this->hasOne(ConsultLaboratoryUltrasound::class, 'request_id', 'id');
    }

    public function geneXpert()
    {
        return $this->hasOne(ConsultLaboratoryGeneXpert::class, 'request_id', 'id');
    }

    public function dengueRdt()
    {
        return $this->hasOne(ConsultLaboratoryDengueRdt::class, 'request_id', 'id');
    }

    public function serology()
    {
        return $this->hasOne(ConsultLaboratorySerology::class, 'request_id', 'id');
    }

    public function biopsy()
    {
        return $this->hasOne(ConsultLaboratoryBiopsy::class, 'request_id', 'id');
    }

    public function malariaRdt()
    {
        return $this->hasOne(ConsultLaboratoryMalariaRdt::class, 'request_id', 'id');
    }

    public function skinSlit()
    {
        return $this->hasOne(ConsultLaboratorySkinSlitSmear::class, 'request_id', 'id');
    }

    public function wetSmear()
    {
        return $this->hasOne(ConsultLaboratoryWetSmear::class, 'request_id', 'id');
    }

    public function bloodchem()
    {
        return $this->hasOne(ConsultLaboratoryBloodChemistry::class, 'request_id', 'id');
    }

    public function potassium()
    {
        return $this->hasOne(ConsultLaboratoryPotassium::class, 'request_id', 'id');
    }

    public function hematology()
    {
        return $this->hasOne(ConsultLaboratoryHematology::class, 'request_id', 'id');
    }

    public function syphilis()
    {
        return $this->hasOne(ConsultLaboratorySyphilis::class, 'request_id', 'id');
    }

    public function cervical()
    {
        return $this->hasOne(ConsultLaboratoryCervicalCancer::class, 'request_id', 'id');
    }

    public function xray()
    {
        return $this->hasOne(ConsultLaboratoryXray::class, 'request_id', 'id');
    }


    public function getRelatedModel($model)
    {
        return $this->$model;
    }
}
