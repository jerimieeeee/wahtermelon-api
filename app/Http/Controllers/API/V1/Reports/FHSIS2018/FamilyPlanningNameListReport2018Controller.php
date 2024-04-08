<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\FamilyPlanning\ReportFamilyPlanningNameListService;
use Illuminate\Http\Request;

class FamilyPlanningNameListReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ReportFamilyPlanningNameListService $fpNamelistService)
    {
        $namelist = $fpNamelistService->get_report_namelist($request)->get();

        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        // Check if search term is provided
        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            // Split the search term by space
            $keywords = explode(' ', $searchTerm);

            // Filter the namelist collection based on each keyword
            $filteredNamelist = $namelist->filter(function ($item) use ($keywords) {
                foreach ($keywords as $keyword) {
                    if (stripos($item->last_name, $keyword) !== false ||
                        stripos($item->middle_name, $keyword) !== false ||
                        stripos($item->first_name, $keyword) !== false) {
                        return true;
                    }
                }
                return false;
            });
        } else {
            // If no search term provided, use the original namelist
            $filteredNamelist = $namelist;
        }

        // Paginate the filtered results
        return $filteredNamelist->paginate($perPage);

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
