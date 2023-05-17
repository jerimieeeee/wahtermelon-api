<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConfConcernRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConfConcernResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConfConcern;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvConfConcernController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvConfConcern::query()
            ->with(['patientGbvConf', 'concern'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConfConcern = QueryBuilder::for($query);

        return PatientGbvConfConcernResource::collection($patientGbvConfConcern->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvConfConcernRequest $request)
    {
        $data = PatientGbvConfConcern::create($request->validated());

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
    public function update(PatientGbvConfConcernRequest $request, PatientGbvConfConcern $patientGbvConfConcern)
    {
        $patientGbvConfConcern->update($request->safe()->only(['concern_code', 'concern_remarks']));

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
