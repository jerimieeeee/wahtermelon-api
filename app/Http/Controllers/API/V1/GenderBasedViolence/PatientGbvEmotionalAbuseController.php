<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvEmotionalAbuseRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvEmotionalAbuseResource;
use App\Models\V1\GenderBasedViolence\PatientGbvEmotionalAbuse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvEmotionalAbuseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvEmotionalAbuse::query()
            ->with(['patientGbv', 'neglectAbuse'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvEmotionalAbuse = QueryBuilder::for($query);

        return PatientGbvEmotionalAbuseResource::collection($patientGbvEmotionalAbuse->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvEmotionalAbuseRequest $request)
    {
        PatientGbvEmotionalAbuse::query()
            ->where('patient_id', $request->safe()->patient_id)
            ->where('intake_id', $request->safe()->intake_id)
            ->delete();

        $emotional_abused = $request->safe()->abused_array;

        foreach ($emotional_abused as $value) {
            PatientGbvEmotionalAbuse::updateOrCreate([
                'patient_id' => $request->patient_id,
                'intake_id' => $request->intake_id,
                'info_source_id' => $value['info_source_id'],
                'emotional_id' => $value['abused_id']
            ], $value);
        };

        return response()->json(['message' => 'Successfully Saved!'], 201);
        /* $data = PatientGbvEmotionalAbuse::create($request->validated());

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
    public function update(PatientGbvEmotionalAbuseRequest $request, PatientGbvEmotionalAbuse $patientGbvEmotionalAbuse)
    {
        $patientGbvEmotionalAbuse->update($request->safe()->only(['emotional_id', 'emotional_abused_remarks']));

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
