<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvSocialWorkRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvSocialWorkResource;
use App\Models\V1\GenderBasedViolence\PatientGbvSocialWork;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvSocialWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvSocialWork::query()
            ->with(['patientGbv'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvSocialWork = QueryBuilder::for($query);

        return PatientGbvSocialWorkResource::collection($patientGbvSocialWork->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvSocialWorkRequest $request)
    {
        $data = PatientGbvSocialWork::create($request->validated());

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
    public function update(PatientGbvSocialWorkRequest $request, PatientGbvSocialWork $patientGbvSocialWork)
    {
        $patientGbvSocialWork->update($request->safe()->only(['visit_date', 'social_worker']));

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
