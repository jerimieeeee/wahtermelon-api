<?php

namespace App\Http\Controllers\API\V1\Reports\AnimalBite;

use App\Http\Controllers\Controller;
use App\Services\AnimalBite\AnimalBiteReportPreExposureNameListService;
use App\Services\AnimalBite\ReportAnimalBiteCohortNameListService;
use App\Services\AnimalBite\ReportAnimalBitePreExposureNameListService;
use App\Services\Morbidity\ReportMorbidityNameListService;
use Illuminate\Http\Request;

class AnimalBitePreExposureNameListReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AnimalBiteReportPreExposureNameListService $nameListService)
    {
        $namelist = $nameListService->get_ab_pre_exp_prophylaxis_name_list($request)->get();

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

        // Count the total number of items in the filtered namelist
        $totalItems = $filteredNamelist->count();

        // Calculate the last page
        $lastPage = ceil($totalItems / $perPage);

        // Paginate the filtered namelist
        $page = $request->has('page') ? $request->input('page') : 1;
        $offset = ($page - 1) * $perPage;
        $data = $filteredNamelist->slice($offset, $perPage)->values();

        return [
            'current_page' => $page,
            'last_page' => $lastPage,
            'data' => $data,
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
