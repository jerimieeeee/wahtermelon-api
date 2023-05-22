<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConsultVisitRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConsultVisitResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConsultVisit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvConsultVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvConsultVisit::query()
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConsult = QueryBuilder::for($query);

        return PatientGbvConsultVisitResource::collection($patientGbvConsult->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvConsultVisitRequest $request)
    {
        $data = PatientGbvConsultVisit::updateOrCreate(['id' => $request->id], $request->validated());

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
