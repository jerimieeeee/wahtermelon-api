<?php

namespace App\Services\FamilyPlanning;

use Illuminate\Support\Facades\DB;

class FamilyPlanningReportService
{
    public function get_projected_population()
    {
        return DB::table('settings_catchment_barangays')
            ->selectRaw('
                        facility_code,
                        barangay_code,
                        name AS barangay_name,
                        year,
                        settings_catchment_barangays.population,
                        (SELECT SUM(population) FROM settings_catchment_barangays) AS total_population
                    ')
            ->leftJoin('barangays', 'barangays.code', '=', 'settings_catchment_barangays.barangay_code')
            ->whereFacilityCode(auth()->user()->facility_code)
            ->groupBy('facility_code', 'barangay_code', 'year', 'population');
    }

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
            ->selectRaw("
                        patient_id,
                        CONCAT(household_folders.address, ',', ' ', barangays.name, ',', ' ', municipalities.name) AS address,
                        municipalities.code AS municipality_code,
                        barangays.code AS barangay_code
                    ")
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id')
            ->join('patients', 'household_members.patient_id', '=', 'patients.id')
            ->groupBy('patient_id', 'municipalities.code', 'barangays.code');
    }

    public function new_acceptor($request, $method, $client, $age_bracket1, $age_bracket2, $code)
    {
        $previous_month = $request->month - 1;

        return DB::table(function ($query) use ($request, $method, $client, $age_bracket1, $age_bracket2, $previous_month, $code) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            municipalities_brgy.address,
                            birthdate,
                            TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) AS age
                ")
                ->from('patient_fp_methods')
                ->join('patients', 'patient_fp_methods.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_fp_methods.patient_id');
                })
                ->when($request->category == 'all', function ($q) {
                    $q->where('patient_fp_methods.facility_code', auth()->user()->facility_code);
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
                ->whereMethodCode($method)
                ->whereClientCode($client)
                ->when($code == 'NA-present-MONTH', fn ($query) =>
                    $query->whereYear('enrollment_date', $request->year)
                        ->whereMonth('enrollment_date',  $request->month)
                )
                ->when($code == 'NA-previous-MONTH', fn ($query)  =>
                    $query->whereYear('enrollment_date',  $request->year)
                          ->whereMonth('enrollment_date', $previous_month)
                    )
                ->havingRaw('age BETWEEN ? AND ?', [$age_bracket1, $age_bracket2]);
        });
    }

    public function other_acceptor($request, $method, $client, $age_bracket1, $age_bracket2)
    {
        return DB::table(function ($query) use ($request, $method, $client, $age_bracket1, $age_bracket2) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            municipalities_brgy.address,
                            birthdate,
                            TIMESTAMPDIFF(YEAR, birthdate, enrollment_date) AS age
                ")
                ->from('patient_fp_methods')
                ->join('patients', 'patient_fp_methods.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_fp_methods.patient_id');
                })
                ->when($request->category == 'all', function ($q) {
                    $q->where('patient_fp_methods.facility_code', auth()->user()->facility_code);
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
                ->whereYear('enrollment_date', $request->year)
                ->whereMonth('enrollment_date',  $request->month)
                ->whereMethodCode($method)
                ->whereIn('client_code', ['CC', 'CM', 'RS'])
                ->havingRaw('age BETWEEN ? AND ?', [$age_bracket1, $age_bracket2]);
        });
    }

    public function dropout($request, $method, $age_bracket1, $age_bracket2)
    {
        return DB::table(function ($query) use ($request, $method, $age_bracket1, $age_bracket2) {
            $query->selectRaw("
                            CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                            municipalities_brgy.address,
                            birthdate,
                            TIMESTAMPDIFF(YEAR, birthdate, dropout_date) AS age
                ")
                ->from('patient_fp_methods')
                ->join('patients', 'patient_fp_methods.patient_id', '=', 'patients.id')
                ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                    $join->on('municipalities_brgy.patient_id', '=', 'patient_fp_methods.patient_id');
                })
                ->when($request->category == 'all', function ($q) {
                    $q->where('patient_fp_methods.facility_code', auth()->user()->facility_code);
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
                ->whereMethodCode($method)
                ->whereIn('dropout_reason_code', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16])
                ->whereYear('dropout_date', $request->year)
                ->whereMonth('dropout_date',  $request->month)
                ->havingRaw('age BETWEEN ? AND ?', [$age_bracket1, $age_bracket2]);
        });
    }
}
