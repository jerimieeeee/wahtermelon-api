<?php

namespace App\Services\Notifiable;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use Illuminate\Support\Facades\DB;

class NotifiableReportService
{
    public function get_catchment_barangays()
    {
        $result = DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code
                    ')
            ->whereFacilityCode(auth()->user()->facility_code);

        return $result->pluck('barangay_code');
    }

    public function get_all_brgy_municipalities_patient()
    {
        return DB::table('municipalities')
            ->selectRaw('
                        patient_id,
                        municipalities.code AS municipality_code,
                        barangays.code AS barangay_code
                    ')
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->groupBy('patient_id', 'municipalities.code', 'barangays.code');
    }

    public function get_notifiable($request, $icd10)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        notifiable_name
                        municipality_code,
                        barangay_code
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_vitals.patient_id');
            })
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_vitals.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            })
            ->when($icd10 == 'paralysis', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A80', 'A80.0', 'A80.1', 'A80.2', 'A80.3', 'A80.4', 'A80.9', 'P35.8'])
            )
            ->when($icd10 == 'fever', fn ($q) =>
                $q->where('consult_notes_final_dxes.icd10_code', 'A92.8')
            )
            ->when($icd10 == 'anthrax', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A22', 'A22.0', 'A22.1', 'A22.2', 'A22.7', 'A22.7', 'A22.8', 'A22.9'])
            )
            ->when($icd10 == 'ebola', fn ($q) =>
                $q->where('consult_notes_final_dxes.icd10_code', 'A98.4')
            )
            ->when($icd10 == 'hfmd', fn ($q) =>
                $q->where('consult_notes_final_dxes.icd10_code', 'B08.8')
            )
            ->when($icd10 == 'avian', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['J10.0', 'J10.1', 'J10.8'])
            )
            ->when($icd10 == 'measles', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9', 'J17.1', 'Z24.4', 'Z27.4'])
            )
            ->when($icd10 == 'meningococcal', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A39', 'A39.0', 'A39.2', 'A39.3', 'A39.4', 'A39.5', 'A39.8', 'A39.9', 'M01.0', 'M03.0'])
            );
    }
}
