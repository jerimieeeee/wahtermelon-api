<?php

namespace App\Http\Controllers\API\V1\Mortality;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Mortality\PatientMortalityResource;
use App\Models\V1\Mortality\PatientMortality;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PatientMortalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(PatientMortality::class)
        ->when(isset($request->patient_id), function ($q) use ($request) {
            $q->where('patient_id', $request->patient_id);
        })
        ->defaultSort('-created_at')
        ->allowedSorts('created_at');

        return PatientMortalityResource::collection($query->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
