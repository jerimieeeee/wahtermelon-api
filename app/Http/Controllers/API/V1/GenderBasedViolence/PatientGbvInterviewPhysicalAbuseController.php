<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvInterviewPhysicalAbuseRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewPhysicalAbuseResource;
use App\Models\V1\GenderBasedViolence\PatientGbvInterviewPhysicalAbuse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvInterviewPhysicalAbuseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvInterviewPhysicalAbuse::query()
            ->with(['patientGbv', 'physical'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvInterviewPhysicalAbuse = QueryBuilder::for($query);

        return PatientGbvInterviewPhysicalAbuseResource::collection($patientGbvInterviewPhysicalAbuse->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvInterviewPhysicalAbuseRequest $request)
    {
        $data = PatientGbvInterviewPhysicalAbuse::create($request->validated());

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
    public function update(PatientGbvInterviewPhysicalAbuseRequest $request, PatientGbvInterviewPhysicalAbuse $patientGbvInterviewPhysicalAbuse)
    {
        $patientGbvInterviewPhysicalAbuse->update($request->safe()->only(['physical_abused_id', 'physical_abused_remarks']));

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
