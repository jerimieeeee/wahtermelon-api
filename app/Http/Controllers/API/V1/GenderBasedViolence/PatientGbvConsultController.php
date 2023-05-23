<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConsultRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConsultResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConsult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvConsultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvConsult::query()
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConsult = QueryBuilder::for($query);

        return PatientGbvConsultResource::collection($patientGbvConsult->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvConsultRequest $request): JsonResponse
    {
        $data = PatientGbvConsult::updateOrCreate(['id' => $request->id], $request->validated());

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
