<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\patientGbvConRecommendationRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\patientGbvConRecommendationResource;
use App\Models\V1\GenderBasedViolence\patientGbvConRecommendation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class patientGbvConRecommendationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = patientGbvConRecommendation::query()
            ->with(['patientGbvConference', 'recommendation'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConRecommendation = QueryBuilder::for($query);

        return patientGbvConRecommendationResource::collection($patientGbvConRecommendation->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(patientGbvConRecommendationRequest $request)
    {
        $data = patientGbvConRecommendation::create($request->validated());

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
    public function update(patientGbvConRecommendationRequest $request, patientGbvConRecommendation $patientGbvConRecommendation)
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
