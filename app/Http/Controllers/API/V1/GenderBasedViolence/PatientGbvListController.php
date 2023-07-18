<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvResource;
use App\Models\V1\GenderBasedViolence\PatientGbv;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $patientGbv = QueryBuilder::for(PatientGbv::class)
            ->whereNull('outcome_date')
            ->with('patient')
            ->defaultSort('-gbv_date')
            ->allowedSorts('gbv_date');

        if ($perPage === 'all') {
            return PatientGbvResource::collection($patientGbv->get());
        }

        return PatientGbvResource::collection($patientGbv->paginate($perPage)->withQueryString());
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
