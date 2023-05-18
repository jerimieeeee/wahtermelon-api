<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConfInviteRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConfInviteResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConfInvite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvConfInviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvConfInvite::query()
            ->with(['patientGbvConf', 'invite'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConfInvite = QueryBuilder::for($query);

        return PatientGbvConfInviteResource::collection($patientGbvConfInvite->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvConfInviteRequest $request)
    {
        $data = PatientGbvConfInvite::create($request->validated());

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
    public function update(PatientGbvConfInviteRequest $request, PatientGbvConfInvite $patientGbvConfInvite)
    {
        $patientGbvConfInvite->update($request->safe()->only(['invite_code', 'invite_remarks']));

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
