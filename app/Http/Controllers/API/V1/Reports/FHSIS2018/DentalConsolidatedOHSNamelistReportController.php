<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Dental\DentalConsolidatedOHSNamelistService;
use Illuminate\Http\Request;

class DentalConsolidatedOHSNamelistReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DentalConsolidatedOHSNamelistService $namelistService)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $data = null;

        //Return Medical, Social, Oral Health Status
        if (in_array($request->params, [
            'allergies',
            'hypertension',
            'diabetes',
            'blood_disorder',
            'heart_disease',
            'thyroid',
            'malignancy_flag',
            'blood_transfusion',
            'tattoo',
            'sweet',
            'alcohol',
            'tobacco',
            'nut',
            'dental_carries',
            'gingivitis',
            'periodontal',
            'debris',
            'calculus',
            'dento_facial'
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_medical_hx($request);

            $data = $query->get();
        }

        //Return Temporary Tooth (d/f)
        if (in_array($request->params, [
            'temp_decayed',
            'temp_filled',
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_temporary_tooth_condition($request);

            $data = $query->get();
        }

        //Return Adult Tooth (DMF)
        if (in_array($request->params, [
            'decayed',
            'missing',
            'filled',
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_adult_tooth_condition($request);

            $data = $query->get();
        }

        //Return Dental Services
        if (in_array($request->params, [
            'op_scaling',
            'permanent_filling',
            'temporary_filling',
            'extraction',
            'gum_treatment',
            'sealant',
            'flouride',
            'post_operative',
            'abscess',
            'other_services',
            'referred',
            'counseling',
            'completed',
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_dental_services($request);

            $data = $query->get();
        }

        //Return Orally Fit Children
        if (in_array($request->params, [
            'orally_fit',
            'oral_rehab',
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_dental_ofc($request);

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

/*       $data = $filteredNamelist->paginate($perPage)->withQueryString();

        return $data;*/

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
