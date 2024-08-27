<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Dental\DentalReportService;
use Illuminate\Http\Request;

class DentalReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DentalReportService $dentalReportService)
    {
        //Projected Population
        $projected_population = $dentalReportService->get_projected_population()->get();

//         return $dentalReportService->get_ab_post_exp_prophylaxis($request)->get();

        $part1 = $dentalReportService->get_ab_post_exp_prophylaxis($request)->get();
        $male_dmft = $dentalReportService->get_dmft($request, 'M')->get();
        $female_dmft = $dentalReportService->get_dmft($request, 'F')->get();

        return [
            'catchment_population' => $projected_population,
            'data' => $part1,
            'dental_dmft'  => [
                'male' => $male_dmft[0]->dmft,
                'female' => $female_dmft[0]->dmft
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
