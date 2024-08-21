<?php

namespace App\Services\Mortality;

use Illuminate\Support\Facades\DB;

class ReportMortalityNameListService
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
            ->selectRaw("
                        patient_id,
                        CONCAT(household_folders.address, ',', ' ', barangays.name, ',', ' ', municipalities.name) AS address,
                        municipalities.psgc_10_digit_code AS municipality_code,
                        barangays.psgc_10_digit_code AS barangay_code
                    ")
            ->join('barangays', 'municipalities.id', '=', 'barangays.geographic_id')
            ->join('household_folders', 'barangays.psgc_10_digit_code', '=', 'household_folders.barangay_code')
            ->join('household_members', 'household_folders.id', '=', 'household_members.household_folder_id');
    }

    public function get_report_namelist($request)
    {
        return DB::table('patient_death_records')
            ->selectRaw("
                        patient_death_records.patient_id AS patient_id,
                        CONCAT(patients.last_name, ',', ' ', patients.first_name, ',', ' ', patients.middle_name) AS name,
                        patients.last_name,
                        patients.first_name,
                        patients.middle_name,
                        patients.birthdate
                        ")
            ->join('patients', 'patient_death_records.patient_id', '=', 'patients.id')
            ->leftJoin('patient_mc', 'patient_death_records.patient_id', '=', 'patient_mc.patient_id')
            ->leftJoin('patient_mc_post_registrations', 'patient_mc.id', '=', 'patient_mc_post_registrations.patient_mc_id')
            ->join('users', 'patient_death_records.user_id', '=', 'users.id')
            ->joinSub($this->get_all_brgy_municipalities_patient(), 'municipalities_brgy', function ($join) {
                $join->on('municipalities_brgy.patient_id', '=', 'patient_death_records.patient_id');
            })
            ->when(auth()->user()->reports_flag == 0 || auth()->user()->reports_flag == NULL, function ($q) {
                $q->where('patient_death_records.facility_code', auth()->user()->facility_code);
            })
            //male_total_deaths
            ->when($request->params == 'male_total_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereIn('death_type', ['ENEOD', 'INFD', 'MATD', 'MARTLY', 'NEOD', 'UDFD'])
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //female_total_deaths
            ->when($request->params == 'female_total_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('death_type', ['ENEOD', 'INFD', 'MATD', 'MARTLY', 'NEOD', 'UDFD'])
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_female_total_deaths
            ->when($request->params == 'male_female_total_deaths', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F'])
                    ->whereIn('death_type', ['ENEOD', 'INFD', 'MATD', 'MARTLY', 'NEOD', 'UDFD'])
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_maternal_deaths
            ->when($request->params == 'male_maternal_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->where('death_type', 'MATD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //female_maternal_deaths
            ->when($request->params == 'female_maternal_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->where('death_type', 'MATD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_female_maternal_deaths
            ->when($request->params == 'male_female_maternal_deaths', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F'])
                    ->where('death_type', 'MATD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_under_five_deaths
            ->when($request->params == 'male_under_five_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->where('death_type', 'UDFD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //female_under_five_deaths
            ->when($request->params == 'female_under_five_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->where('death_type', 'UDFD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_female_under_five_deaths
            ->when($request->params == 'male_female_under_five_deaths', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F'])
                    ->where('death_type', 'UDFD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_infant_deaths
            ->when($request->params == 'male_infant_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->where('death_type', 'INFD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //female_infant_deaths
            ->when($request->params == 'female_infant_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->where('death_type', 'INFD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_female_infant_deaths
            ->when($request->params == 'male_female_infant_deaths', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F'])
                    ->where('death_type', 'INFD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_neonatal_deaths
            ->when($request->params == 'male_neonatal_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->where('death_type', 'NEOD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //female_neonatal_deaths
            ->when($request->params == 'female_neonatal_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->where('death_type', 'NEOD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_female_neonatal_deaths
            ->when($request->params == 'male_female_neonatal_deaths', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F'])
                    ->where('death_type', 'NEOD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_fetal_deaths
            ->when($request->params == 'male_fetal_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->whereIn('outcome_code', ['FDU', 'SB'])
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            //female_fetal_deaths
            ->when($request->params == 'female_fetal_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('outcome_code', ['FDUF', 'SBF'])
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            //male_female_fetal_deaths
            ->when($request->params == 'male_female_fetal_deaths', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F'])
                    ->whereIn('outcome_code', ['FDU', 'SB', 'FDUF', 'SBF'])
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            //male_early_neonatal_deaths
            ->when($request->params == 'male_early_neonatal_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'M')
                    ->where('death_type', 'ENEOD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //female_early_neontal_deaths
            ->when($request->params == 'female_early_neontal_deaths', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->where('death_type', 'ENEOD')
                    ->whereYear('date_of_death', $request->year)
                    ->whereMonth('date_of_death', $request->month);
            })
            //male_female_early_neontal_deaths
            ->when($request->params == 'male_female_early_neontal_deaths', function ($query) use ($request) {
                $query->whereIn('patients.gender', ['M', 'F'])
                    ->where('death_type', 'ENEOD')
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            //male_perinatal_deaths
            ->when($request->params == 'male_perinatal_deaths', function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('patients.gender', 'M')
                            ->whereIn('outcome_code', ['FDU', 'SB'])
                            ->whereYear('delivery_date', $request->year)
                            ->whereMonth('delivery_date', $request->month);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->where('patients.gender', 'M')
                            ->where('death_type', 'ENEOD')
                            ->whereYear('delivery_date', $request->year)
                            ->whereMonth('delivery_date', $request->month);
                    });
                });
            })
            //female_perinatal_deaths
            ->when($request->params == 'female_perinatal_deaths', function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('patients.gender', 'F')
                            ->whereIn('outcome_code', ['FDUF', 'SBF'])
                            ->whereYear('delivery_date', $request->year)
                            ->whereMonth('delivery_date', $request->month);
                    })
                        ->orWhere(function ($query) use ($request) {
                            $query->where('patients.gender', 'F')
                                ->where('death_type', 'ENEOD')
                                ->whereYear('delivery_date', $request->year)
                                ->whereMonth('delivery_date', $request->month);
                        });
                });
            })
            //male_female_perinatal_deaths
            ->when($request->params == 'male_female_perinatal_deaths', function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereIn('patients.gender', ['M', 'F'])
                            ->whereIn('outcome_code', ['FDU', 'SB', 'FDUF', 'SBF'])
                            ->whereYear('delivery_date', $request->year)
                            ->whereMonth('delivery_date', $request->month);
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->whereIn('patients.gender', ['M', 'F'])
                            ->where('death_type', 'ENEOD')
                            ->whereYear('delivery_date', $request->year)
                            ->whereMonth('delivery_date', $request->month);
                    });
                });
            })
            //live_births_male
            ->when($request->params == 'live_births_male', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('outcome_code', ['LSCSM', 'NSDM'])
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            //live_births_female
            ->when($request->params == 'live_births_male', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('outcome_code', ['LSCSF', 'NDSF'])
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            //live_births_male_female
            ->when($request->params == 'live_births_male', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('outcome_code', ['LSCSM', 'NSDM', 'LSCSF', 'NDSF'])
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            //live_births_15_19_male
            ->when($request->params == 'live_births_15_19_male', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('outcome_code', ['LSCSM', 'NSDM'])
                    ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, date_of_death) BETWEEN 15 AND 19")
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            //live_births_15_19_female
            ->when($request->params == 'live_births_15_19_female', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('outcome_code', ['LSCSF', 'NDSF'])
                    ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, date_of_death) BETWEEN 15 AND 19")
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            //live_births_15_19_male_female
            ->when($request->params == 'live_births_15_19_male_female', function ($query) use ($request) {
                $query->where('patients.gender', 'F')
                    ->whereIn('outcome_code', ['LSCSF', 'LSCSM', 'NDSF', 'NSDM'])
                    ->whereRaw("TIMESTAMPDIFF(MONTH, patients.birthdate, date_of_death) BETWEEN 15 AND 19")
                    ->whereYear('delivery_date', $request->year)
                    ->whereMonth('delivery_date', $request->month);
            })
            ->when($request->category == 'fac', function ($q) {
                $q->whereIn('municipalities_brgy.barangay_code', $this->get_catchment_barangays());
            })
            ->when($request->category == 'muncity', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.municipality_code', explode(',', $request->code));
            })
            ->when($request->category == 'brgys', function ($q) use ($request) {
                $q->whereIn('municipalities_brgy.barangay_code', explode(',', $request->code));
            });
    }
}
