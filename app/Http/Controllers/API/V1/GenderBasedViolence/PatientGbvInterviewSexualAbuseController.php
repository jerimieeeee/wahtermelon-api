<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvInterviewSexualAbuseRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewSexualAbuseResource;
use App\Models\V1\GenderBasedViolence\PatientGbvInterviewSexualAbuse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvInterviewSexualAbuseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvInterviewSexualAbuse::query()
            ->with(['patientGbv', 'sexual'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvInterviewSexualAbuse = QueryBuilder::for($query);

        return PatientGbvInterviewSexualAbuseResource::collection($patientGbvInterviewSexualAbuse->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvInterviewSexualAbuseRequest $request)
    {
        PatientGbvInterviewSexualAbuse::query()
            ->where('patient_id', $request->safe()->patient_id)
            ->where('intake_id', $request->safe()->intake_id)
            ->delete();

        $sexual_abused = $request->safe()->abused_array;

        foreach ($sexual_abused as $value) {
            PatientGbvInterviewSexualAbuse::updateOrCreate([
                'patient_id' => $request->patient_id,
                'intake_id' => $request->intake_id,
                'info_source_id' => $value['info_source_id'],
                'sexual_abused_id' => $value['abused_id'],
            ], $value);
        }

        return response()->json(['message' => 'Successfully Saved!'], 201);
        /* $data = PatientGbvInterviewSexualAbuse::create($request->validated());

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
    public function update(PatientGbvInterviewSexualAbuseRequest $request, PatientGbvInterviewSexualAbuse $patientGbvInterviewSexualAbuse)
    {
        $patientGbvInterviewSexualAbuse->update($request->safe()->only(['sexual_abused_id', 'sexual_abused_remarks']));

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
