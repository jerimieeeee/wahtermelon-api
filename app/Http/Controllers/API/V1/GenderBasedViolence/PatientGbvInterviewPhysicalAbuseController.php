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
        PatientGbvInterviewPhysicalAbuse::query()
            ->where('patient_id', $request->safe()->patient_id)
            ->where('intake_id', $request->safe()->intake_id)
            ->delete();

        $sexual_abused = $request->safe()->abused_array;

        foreach ($sexual_abused as $value) {
            PatientGbvInterviewPhysicalAbuse::updateOrCreate([
                'patient_id' => $request->patient_id,
                'intake_id' => $request->intake_id,
                'info_source_id' => $value['info_source_id'],
                'physical_abused_id' => $value['abused_id']
            ], $value);
        };

        return response()->json(['message' => 'Successfully Saved!'], 201);
        /* $data = PatientGbvInterviewPhysicalAbuse::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Successfully saved'], 201); */
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
