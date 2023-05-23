<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvInterviewNeglectAbuseRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewNeglectAbuseResource;
use App\Models\V1\GenderBasedViolence\PatientGbvInterviewNeglectAbuse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvInterviewNeglectAbuseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvInterviewNeglectAbuse::query()
            ->with(['patientGbv', 'neglectAbuse'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvInterviewNeglectAbuse = QueryBuilder::for($query);

        return PatientGbvInterviewNeglectAbuseResource::collection($patientGbvInterviewNeglectAbuse->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvInterviewNeglectAbuseRequest $request)
    {
        PatientGbvInterviewNeglectAbuse::query()
            ->where('patient_id', $request->safe()->patient_id)
            ->where('intake_id', $request->safe()->intake_id)
            ->delete();

        $emotional_abused = $request->safe()->abused_array;

        foreach ($emotional_abused as $value) {
            PatientGbvInterviewNeglectAbuse::updateOrCreate([
                'patient_id' => $request->patient_id,
                'intake_id' => $request->intake_id,
                'info_source_id' => $value['info_source_id'],
                'neglect_abused_id' => $value['abused_id']
            ], $value);
        };

        return response()->json(['message' => 'Successfully Saved!'], 201);
        /* $data = PatientGbvInterviewNeglectAbuse::create($request->validated());

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
    public function update(PatientGbvInterviewNeglectAbuseRequest $request, PatientGbvInterviewNeglectAbuse $patientGbvInterviewNeglectAbuse)
    {
        $patientGbvInterviewNeglectAbuse->update($request->safe()->only(['neglect_abused_id', 'neglect_abused_remarks']));

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
