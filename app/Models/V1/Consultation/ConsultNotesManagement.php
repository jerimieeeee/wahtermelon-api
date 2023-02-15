<?php

namespace App\Models\V1\Consultation;

use App\Models\V1\Libraries\LibManagement;
use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultNotesManagement extends Model
{
    use HasFactory, HasUuids, FilterByUser;

    protected $keyType = 'string';

    protected $guarded = [
        'id'
    ];

    public function getRouteKeyName()
    {
        return 'notes_id';
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function consultNotes()
    {
        return $this->belongsTo(ConsultNotes::class, 'notes_id', 'id');
    }

    public function libManagement()
    {
        return $this->belongsTo(LibManagement::class, 'management_code', 'code');
    }
}
