<?php

namespace App\Http\Controllers\API\V1\Reports\AnimalBite;

use App\Http\Controllers\Controller;
use App\Services\AnimalBite\AnimalBiteReportPreExposureNameListService;
use Illuminate\Http\Request;

class AnimalBitePreExposureNameListReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AnimalBiteReportPreExposureNameListService $nameListService)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $data = null;

        //Return catchment
        if (in_array($request->indicator, [
                'male',
                'female',
                'male_female_total',
                'less_than_15',
                'greater_than_15',
                'less_than_and_greater_than_15',
                'category1',
                'category2',
                'category3',
                'total_cat2_and_cat3',
                'total_cat1_cat2_cat3',
                'prep_total',
                'prep_completed',
                'tandok',
                'pep_completed',
                'tcv',
                'HRIG',
                'ERIG',
                'dog',
                'cat',
                'others',
                'total_biting_animal',
            ])
            && $request->type === 'catchment'
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_ab_pre_exp_prophylaxis_name_list($request);

            $data = $query->get();
        }

        //Return non-catchment
        if (
            in_array($request->indicator, [
                'male',
                'female',
                'male_female_total',
                'less_than_15',
                'greater_than_15',
                'less_than_and_greater_than_15',
                'category1',
                'category2',
                'category3',
                'total_cat2_and_cat3',
                'total_cat1_cat2_cat3',
                'prep_total',
                'prep_completed',
                'tandok',
                'pep_completed',
                'tcv',
                'HRIG',
                'ERIG',
                'dog',
                'cat',
                'others',
                'total_biting_animal',
            ])
            && $request->type === 'non-catchment'
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_ab_pre_exp_prophylaxis_others($request);

            $data = $query->get();
        }

        //Return catchment
        if (
           in_array($request->indicator, [
               'total_cat2_and_cat3_previous_quarter',
               'pep_completed_previous',
                   ])
            && $request->type === 'catchment'
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_previous_quarter_cat2_cat3($request);

            $data = $query->get();
        }

        //Return non-catchment
        if (
            in_array($request->indicator, [
                'total_cat2_and_cat3_previous_quarter',
                'pep_completed_previous',
            ])
            && $request->type === 'non-catchment'
        ) {
            // If the condition is true, fetch the data
            $query = $nameListService->get_previous_quarter_cat2_cat3_others($request);

            $data = $query->get();
        }


        // Check if search term is provided
        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            // Split the search term by space
            $keywords = explode(' ', $searchTerm);

            // Filter the namelist collection based on each keyword
            $filteredNamelist = $data->filter(function ($item) use ($keywords) {
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
            $filteredNamelist = $data;
        }

        // Count the total number of items in the filtered namelist
        if (is_null($filteredNamelist)) {
            // Handle the case when $filteredNamelist is null
            $totalItems = 0;
        } else {
            $totalItems = $filteredNamelist->count();
        }

        // Calculate the last page
        $lastPage = ceil($totalItems / $perPage);

        // Paginate the filtered namelist
        $page = $request->has('page') ? $request->input('page') : 1;
        $offset = ($page - 1) * $perPage;

        $filteredNamelist = $filteredNamelist ?? collect();
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
