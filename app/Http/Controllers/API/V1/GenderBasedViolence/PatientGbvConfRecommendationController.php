<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConfRecommendationRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConfRecommendationResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConfRecommendation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvConfRecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvConfRecommendation::query()
            ->with(['patientGbvConf', 'recommendation'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConfRecommendation = QueryBuilder::for($query);

        return PatientGbvConfRecommendationResource::collection($patientGbvConfRecommendation->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvConfRecommendationRequest $request)
    {
        $data = PatientGbvConfRecommendation::create($request->validated());

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
    public function update(patientGbvConfRecommendationRequest $request, patientGbvConfRecommendation $patientGbvConRecommendation)
    {
        $patientGbvConRecommendation->update($request->safe()->only(['recommend_code', 'recommendation_remarks', 'recommendation_date']));

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
