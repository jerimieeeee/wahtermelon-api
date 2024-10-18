<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Household\HouseholdEnvironmentalReportService;
use Illuminate\Http\Request;

class HouseholdEnvironmentalReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, HouseholdEnvironmentalReportService $householdEnvironmentalService)
    {
        // Projected Population
        $projected_population = $householdEnvironmentalService->get_projected_population()->get();

        //Water Supply
        $water_level_all = $householdEnvironmentalService->get_household_environmental_water_source($request, 'all')->get()->groupBy('family_id');
        $water_level1 = $householdEnvironmentalService->get_household_environmental_water_source($request, 1)->get()->groupBy('family_id');
        $water_level2 = $householdEnvironmentalService->get_household_environmental_water_source($request, 2)->get()->groupBy('family_id');
        $water_level3 = $householdEnvironmentalService->get_household_environmental_water_source($request, 3)->get()->groupBy('family_id');

        //Safety Managed Drinking Water Services
        $safety_managed_water = $householdEnvironmentalService->get_household_environmental_safety_managed_water($request)->get()->groupBy('family_id');

        //Basic Sanitation Facility
        $basic_sanitation_toilet_all = $householdEnvironmentalService->get_household_environmental_toilet_type($request, 'all')->get()->groupBy('family_id');
        $basic_sanitation_toilet_a = $householdEnvironmentalService->get_household_environmental_toilet_type($request, 1)->get()->groupBy('family_id');
        $basic_sanitation_toilet_b = $householdEnvironmentalService->get_household_environmental_toilet_type($request, 2)->get()->groupBy('family_id');
        $basic_sanitation_toilet3_c = $householdEnvironmentalService->get_household_environmental_toilet_type($request, 3)->get()->groupBy('family_id');

        //Safety Managed Sanitation Services
        $safety_managed_sanitation = $householdEnvironmentalService->get_household_environmental_safety_managed_sanitation($request)->get()->groupBy('family_id');

        //Satisfaction Solid Waste Management
        $satisfaction_solid_waste_management = $householdEnvironmentalService->get_household_environmental_satisfaction_solid_waste($request)->get()->groupBy('family_id');

        //Complete Sanitation Facilities
        $complete_sanitation_facilities = $householdEnvironmentalService->get_household_environmental_complete_sanitation($request)->get()->groupBy('family_id');

        //Total Number of Barangays ZOD
        $zod_barangays = $householdEnvironmentalService->get_zod_barangays($request)->get();

        return [
            //GET PROJECTED POPULATION
            'projected_population' => $projected_population,

            // Water Supply
            'water_level_all' => $water_level_all,
            'water_level1' => $water_level1,
            'water_level2' => $water_level2,
            'water_level3' => $water_level3,

            // Safety Managed Drinking Water Services
            'safety_managed_water' => $safety_managed_water,

            //Basic Sanitation Facility
            'basic_sanitation_toilet_all' => $basic_sanitation_toilet_all,
            'basic_sanitation_toilet_a' => $basic_sanitation_toilet_a,
            'basic_sanitation_toilet_b' => $basic_sanitation_toilet_b,
            'basic_sanitation_toilet_c' => $basic_sanitation_toilet3_c,

            //Safety Managed Sanitation Services
            'safety_managed_sanitation' => $safety_managed_sanitation,

            //Safety Managed Sanitation Services
            'satisfaction_solid_waste_management' => $satisfaction_solid_waste_management,

            //Complete Sanitation Facilities
            'complete_sanitation_facilities' => $complete_sanitation_facilities,

            //Total Number of Barangays ZOD
            'zod_barangays' => $zod_barangays,
         ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
