<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvPlacementRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvPlacementResource;
use App\Models\V1\GenderBasedViolence\PatientGbvPlacement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvPlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvPlacement::query()
            ->with(['patientGbv', 'location', 'placementType'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvPlacement = QueryBuilder::for($query);

        return PatientGbvPlacementResource::collection($patientGbvPlacement->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvPlacementRequest $request)
    {
        $data = PatientGbvPlacement::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Successfully saved'], 201);
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
    public function update(PatientGbvPlacementRequest $request, PatientGbvPlacement $patientGbvPlacement)
    {
        $patientGbvPlacement->update($request->safe()->only(['location_id', 'home_by_cpu_flag', 'home_by_other_name',
            'scheduled_date', 'actual_date', 'placement_name',
            'placement_contact_info', 'type_id', 'hospital_name', 'hospital_ward', 'hospital_date_in', 'hospital_date_out']));

        return response()->json(['status' => 'Update successful!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
