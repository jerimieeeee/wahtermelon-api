<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvInterviewEmotionalAbuseRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewNeglectAbuseResource;
use App\Models\V1\GenderBasedViolence\PatientGbvInterviewEmotionalAbuse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvInterviewEmotionalAbuseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvInterviewEmotionalAbuse::query()
            ->with(['patientGbv', 'neglectAbuse'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvInterviewEmotionalAbuse = QueryBuilder::for($query);

        return PatientGbvInterviewNeglectAbuseResource::collection($patientGbvInterviewEmotionalAbuse->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvInterviewEmotionalAbuseRequest $request)
    {
        $data = PatientGbvInterviewEmotionalAbuse::create($request->validated());

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
    public function update(PatientGbvInterviewEmotionalAbuseRequest $request, PatientGbvInterviewEmotionalAbuse $patientGbvInterviewEmotionalAbuse)
    {
        $patientGbvInterviewEmotionalAbuse->update($request->safe()->only(['emotional_id', 'emotional_abused_remarks']));

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
