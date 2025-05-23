<?php

namespace App\Http\Controllers\API\V1\Household;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Household\HouseholdEnvironmentalRequest;
use App\Http\Resources\API\V1\FamilyPlanning\PatientFpResource;
use App\Http\Resources\API\V1\Household\HouseholdEnvironmentalResource;
use App\Models\V1\FamilyPlanning\PatientFp;
use App\Models\V1\Household\HouseholdEnvironmental;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class HouseholdEnvironmentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(HouseholdEnvironmental::class)
            ->when(isset($request->household_folder_id), function ($q) use ($request) {
                $q->where('household_folder_id', $request->household_folder_id);
            })
            ->when(isset($request->effectivity_year), function ($q) use ($request) {
                $q->where('effectivity_year', $request->effectivity_year);
            })
            ->with(['waterTypes', 'toiletFacility', 'sewage', 'wasteManagement'])
            ->defaultSort('-registration_date')
            ->allowedSorts('arsenic_date', 'registration_date', 'validation_date');

        if ($perPage === 'all') {
            return HouseholdEnvironmentalResource::collection($query->get());
        }

        return HouseholdEnvironmentalResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HouseholdEnvironmentalRequest $request): JsonResponse
    {
        HouseholdEnvironmental::updateOrCreate(['household_folder_id' => $request->safe()->household_folder_id, 'effectivity_year' => $request->safe()->effectivity_year], $request->validated());

        return response()->json(['status' => 'Successfully Saved!'], 201);
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
    public function destroy(HouseholdEnvironmental $householdEnvironmental)
    {
        $householdEnvironmental->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
