<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\patientGbvEmotionalAbuseRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewNeglectAbuseResource;
use App\Models\V1\GenderBasedViolence\patientGbvEmotionalAbuse;
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
        $query = patientGbvEmotionalAbuse::query()
            ->with(['patientGbv', 'neglectAbuse'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvEmotionalAbuse = QueryBuilder::for($query);

        return PatientGbvInterviewNeglectAbuseResource::collection($patientGbvEmotionalAbuse->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(patientGbvEmotionalAbuseRequest $request)
    {
        $data = patientGbvEmotionalAbuse::create($request->validated());

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
    public function update(patientGbvEmotionalAbuseRequest $request, patientGbvEmotionalAbuse $patientGbvEmotionalAbuse)
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
