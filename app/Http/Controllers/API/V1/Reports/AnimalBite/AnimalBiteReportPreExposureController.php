<?php

namespace App\Http\Controllers\API\V1\Reports\AnimalBite;

use App\Http\Controllers\Controller;
use App\Services\AnimalBite\AnimalBiteReportCohortService;
use App\Services\AnimalBite\AnimalBiteReportPreExposureService;
use Illuminate\Http\Request;

class AnimalBiteReportPreExposureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AnimalBiteReportPreExposureService $animalbite)
    {
        //Projected Population

        $part1 = $animalbite->get_ab_pre_exp_prophylaxis($request)->get();

        return [
            'data' => $part1,
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
