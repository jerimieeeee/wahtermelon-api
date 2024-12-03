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

    public function get_notifiable($request, $icd10)
    {
        return DB::table('consult_notes_final_dxes')
            ->selectRaw("
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        CONCAT(household_folders.address, ',', ' ', barangays.name) AS address,
                        birthdate
                    ")
            ->join('consult_notes', 'consult_notes_final_dxes.notes_id', '=', 'consult_notes.id')
            ->join('consults', 'consult_notes.consult_id', '=', 'consults.id')
            ->join('patients', 'consult_notes.patient_id', '=', 'patients.id')
            ->join('lib_icd10s', 'consult_notes_final_dxes.icd10_code', '=', 'lib_icd10s.icd10_code')
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.psgc_10_digit_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->tap(function ($query) use ($request) {
                $this->categoryFilterService->applyCategoryFilter($query, $request, 'consult_notes_final_dxes.facility_code');
            })
            //CAT I
            ->when($icd10 == 'paralysis', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A80', 'A80.0', 'A80.1', 'A80.2', 'A80.3', 'A80.4', 'A80.9', 'P35.8'])
            )
            ->when($icd10 == 'anthrax', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A22', 'A22.0', 'A22.1', 'A22.2', 'A22.7', 'A22.8', 'A22.9'])
            )
            ->when($icd10 == 'avian', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['J10.0', 'J10.1', 'J10.8'])
            )
            ->when($icd10 == 'measles', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['B05', 'B05.0', 'B05.1', 'B05.2', 'B05.3', 'B05.4', 'B05.8', 'B05.9', 'B06', 'B06.0', 'B06.8', 'B06.9', 'J17.1', 'Z24.4', 'Z27.4'])
            )
            ->when($icd10 == 'meningococcal', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A39', 'A39.0', 'A39.2', 'A39.3', 'A39.4', 'A39.5', 'A39.8', 'A39.9', 'M01.0', 'M03.0'])
            )
            ->when($icd10 == 'neo-tetanus', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A33', 'P71.3'])
            )
            ->when($icd10 == 'shellfish', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['T61.0', 'T61.1', 'T61.2', 'T61.8'])
            )
            ->when($icd10 == 'rabies', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A82', 'A82.0', 'A82.1', 'A82.9'])
            )
            ->when($icd10 == 'sars', fn ($q) =>
                $q->where('consult_notes_final_dxes.icd10_code', 'U04.9')
            )
            //CAT II
            ->when($icd10 == 'diarrhea', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A06', 'A06.0', 'A06.1', 'A09'])
            )
            ->when($icd10 == 'encephalitis', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A32.1', 'A83', 'A83.0', 'A83.8', 'A83.9', 'A86'])
            )
            ->when($icd10 == 'fever', fn ($q) =>
                $q->where('consult_notes_final_dxes.icd10_code', 'A92.8')
            )
            ->when($icd10 == 'hepatitis', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['B15', 'B15.9', 'B16', 'B17', 'B17.0', 'B17.1', 'B17.2', 'B17.8', 'B18', 'B18.2', 'B18.8', 'B18.9', 'B19'])
            )
            ->when($icd10 == 'meningitis', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['G00', 'G00.8', 'G00.9', 'G03.1', 'G03.9'])
            )
            ->when($icd10 == 'cholera', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A00', 'A00.0', 'A00.1', 'A00.10', 'A00.9'])
            )
            ->when($icd10 == 'dengue', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A90', 'A91', 'A91.0', 'A91.1', 'A91.2', 'A91.3', 'A91.9'])
            )
            ->when($icd10 == 'diphtheria', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A36', 'A36.0', 'A36.1', 'A36.2', 'A36.3', 'A36.8', 'A36.9'])
            )
            ->when($icd10 == 'influenza', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['J10', 'J11'])
            )
            ->when($icd10 == 'leptospirosis', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A27', 'A27.0', 'A27.8', 'A27.9'])
            )
            ->when($icd10 == 'malaria', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code',
                    ['B50', 'B50.0', 'B50.00', 'B50.01', 'B50.8', 'B50.80', 'B50.81',
                     'B50.9', 'B51', 'B51.0', 'B51.8', 'B51.9', 'B52', 'B52.0', 'B52.8',
                     'B52.80', 'B52.9', 'B53', 'B53.0', 'B53.1', 'B53.8', 'B54', 'D63.8',
                     'D77', 'G94.8', 'P37.3', 'P37.4'])
            )
            ->when($icd10 == 'non-tetanus', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A34', 'A35'])
            )
            ->when($icd10 == 'pertussis', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A37', 'A37.0', 'A37.1', 'A37.8', 'A37.9'])
            )
            ->when($icd10 == 'typhoid', fn ($q) =>
                $q->whereIn('consult_notes_final_dxes.icd10_code', ['A01', 'A01.0', 'A01.1', 'A01.2', 'A01.3', 'A01.4'])
            )
            ->whereYear('consult_date', $request->year)
            ->whereMonth('consult_date', $request->month);
    }
}
