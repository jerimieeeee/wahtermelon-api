<?php

namespace App\Services\AnimalBite;

use App\Models\V1\Libraries\LibNcdRiskStratificationChart;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use Illuminate\Support\Facades\DB;

class AnimalBiteReportService
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

    public function get_animal_bite_case($request, $gender, $age)
    {
        return DB::table('patient_abs')
            ->selectRaw("
                        barangays.name AS barangay_name,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                        birthdate,
                        TIMESTAMPDIFF(YEAR, patients.birthdate, exposure_date) AS age
                    ")
            ->join('patient_ab_exposures', 'patient_abs.id', '=', 'patient_ab_exposures.patient_ab_id')
            ->join('patients', 'patient_abs.patient_id', '=', 'patients.id')
            ->join('household_members', 'patients.id', '=', 'household_members.patient_id')
            ->join('household_folders', 'household_members.household_folder_id', '=', 'household_folders.id')
            ->join('barangays', 'household_folders.barangay_code', '=', 'barangays.code')
            ->join('settings_catchment_barangays', 'barangays.code', '=', 'settings_catchment_barangays.barangay_code')
            ->join('municipalities', 'barangays.geographic_id', '=', 'municipalities.id')
            ->when($request->category == 'all', function ($q) {
                $q->where('patient_abs.facility_code', auth()->user()->facility_code);
            })
            ->when($request->category == 'facility', function ($q) {
                $q->whereIn('barangays.code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'municipality', function ($q) use ($request) {
                $q->whereIn('municipalities.code', explode(',', $request->code));
            })
            ->when($request->category == 'barangay', function ($q) use ($request) {
                $q->whereIn('barangays.code', explode(',', $request->code));
            })
            // All Animal Bite Cases
            ->when($age == 'all-age' && $gender == 'all', function ($q) {
                $q->whereIn('gender', ['M', 'F']);
            })
            // Sex: Male
            ->when($age == 'all-male' && $gender == 'M', function ($q) {
                $q->whereGender('M');
            })
            // Sex: Female
            ->when($age == 'all-female' && $gender == 'F', function ($q) {
                $q->whereGender('F');
            })
            // Age less than 15
            ->when($age == 'less-than15' && $gender == 'all', function ($q) {
                $q->havingRaw('(age < 15)');
            })
            // Age greater than or equal 15
            ->when($age == 'greater-than15' && $gender == 'all', function ($q) {
                $q->havingRaw('(age >= 15)');
            })
            // Type of Animal: Dog
            ->when($age == 'dog' && $gender == 'dog', function ($q) {
                $q->whereAnimalTypeId(1);
            })
            // Type of Animal: Cat
            ->when($age == 'cat' && $gender == 'cat', function ($q) {
                $q->whereAnimalTypeId(2);
            })
            // Type of Animal: Bat
            ->when($age == 'bat' && $gender == 'bat', function ($q) {
                $q->whereAnimalTypeId(3);
            })
            // Type of Animal: Monkey
            ->when($age == 'monkey' && $gender == 'monkey', function ($q) {
                $q->whereAnimalTypeId(4);
            })
            // Type of Animal: Others
            ->when($age == 'others' && $gender == 'others', function ($q) {
                $q->whereAnimalTypeId(5);
            })
            ->whereYear('exposure_date', $request->year)
            ->whereMonth('exposure_date', $request->month);
    }
}
