<?php

namespace App\Services\ReportFilter;
use Illuminate\Support\Facades\DB;

class CategoryFilterService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function get_projected_population()
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw('
                    year,
                    SUM(settings_catchment_barangays.population) AS total_population
                    ')
            ->whereFacilityCode(auth()->user()->facility_code)
            ->groupBy('facility_code');
    }

    public function get_catchment_barangays() {
        $result = DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code
                    ')
            ->whereFacilityCode(auth()->user()->facility_code);

        return $result->pluck('barangay_code');
    }

    public function getAllBrgyMunicipalitiesPatient()
    {
        return DB::table('municipalities')
            ->selectRaw('
                        patient_id,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.psgc_10_digit_code AS barangay_code
                    ')
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.psgc_10_digit_code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id');
    }

    public function applyCategoryFilter($query, $request, $tableColumnFacCode = null, $joinSubColName = null) {

        // $tableColumnFacCode column for category = all
        // $joinSubColName column for getting municipalities

        if(isset($joinSubColName)) {
            $query->joinSub($this->getAllBrgyMunicipalitiesPatient(), 'municipalities_brgy', function ($join) use ($joinSubColName) {
                $join->on('municipalities_brgy.patient_id', '=', $joinSubColName);
            });
        }

        /* if(isset($tableColumnFacCode)) {
            $query->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) use ($tableColumnFacCode) {
                $q->where($tableColumnFacCode, auth()->user()->facility_code);
            });
        } */

        $query->when((auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL) && $request->category == 'fac', function ($q) {
            // If user is not for provincial report
            // get list base on catchment barangay
            $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
        })
        ->when((auth()->user()->reports_flag == 1) && $request->category == 'fac', function ($q) use ($request, $tableColumnFacCode) {
            // If user if provincial report
            // Receive array of facility code
            $q->whereIn($tableColumnFacCode, explode(',', $request->code));
        })
        ->when($request->category == 'muncity', function ($q) use ($request) {
            $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
        })
        ->when($request->category == 'brgys', function ($q) use ($request) {
            $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
        });


        return $query;

    }
}
