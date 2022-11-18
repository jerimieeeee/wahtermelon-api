<?php

namespace App\Models\V1\Consultation;

use DateTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Consult extends Model
{
   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  protected $table='consults';

  protected $primaryKey = 'id';
  protected $guarded = ['id',];

  protected $casts = [
    'consult_date' => 'datetime:Y-m-d H:i:s',
    'is_pregnant' => 'boolean',
    'consult_done' => 'boolean'
];

public function getRouteKeyName()
{
    return 'patient_id';
}

public function consult_notes(){
    return $this->hasOne(ConsultNotes::class, 'consult_id', 'id');
}

}
