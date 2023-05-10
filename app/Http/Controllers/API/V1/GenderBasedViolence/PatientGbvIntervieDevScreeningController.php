<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvInterviewDevScreeningRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvInterviewNeglectAbuseResource;
use App\Models\V1\GenderBasedViolence\PatientGbvInterviewDevScreening;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvIntervieDevScreeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvInterviewDevScreening::query()
            ->with(['patientGbv', 'devScreening'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvInterviewDevScreening = QueryBuilder::for($query);

        return PatientGbvInterviewNeglectAbuseResource::collection($patientGbvInterviewDevScreening->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvInterviewDevScreeningRequest $request)
    {
        $data = PatientGbvInterviewDevScreening::create($request->validated());

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
    public function update(PatientGbvInterviewDevScreeningRequest $request, PatientGbvInterviewDevScreening $patientGbvInterviewDevScreening)
    {
        $patientGbvInterviewDevScreening->update($request->safe()->only('dev_screening_id'));

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
